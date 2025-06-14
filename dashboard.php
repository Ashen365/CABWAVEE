<?php
require_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

// Process form submission for new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_booking') {
    $pickup_location = sanitize($_POST['pickup_location']);
    $dropoff_location = sanitize($_POST['dropoff_location']);
    
    // Validate inputs
    if (empty($pickup_location) || empty($dropoff_location)) {
        $error = "Pickup and dropoff locations are required";
    } else {
        // Insert booking into database
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, pickup_location, dropoff_location, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iss", $_SESSION['user_id'], $pickup_location, $dropoff_location);
        
        if ($stmt->execute()) {
            $success = "Booking created successfully. We will assign a driver soon.";
        } else {
            $error = "Failed to create booking: " . $conn->error;
        }
    }
}

// Cancel booking
if (isset($_GET['cancel']) && is_numeric($_GET['cancel'])) {
    $booking_id = (int)$_GET['cancel'];
    
    // Check if booking belongs to user and is not already completed
    $stmt = $conn->prepare("SELECT status FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $booking_status = $result->fetch_assoc()['status'];
        
        if ($booking_status === 'completed') {
            $error = "Cannot cancel a completed booking";
        } else {
            // Update booking status to cancelled
            $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE booking_id = ?");
            $stmt->bind_param("i", $booking_id);
            
            if ($stmt->execute()) {
                $success = "Booking cancelled successfully";
            } else {
                $error = "Failed to cancel booking: " . $conn->error;
            }
        }
    } else {
        $error = "Booking not found or not owned by you";
    }
}

// Get user's bookings
$bookings = [];
$stmt = $conn->prepare("SELECT b.*, d.name as driver_name, d.phone as driver_phone 
                       FROM bookings b 
                       LEFT JOIN drivers d ON b.driver_id = d.driver_id 
                       WHERE b.user_id = ? 
                       ORDER BY b.booking_time DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Get user info
$user = null;
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
}

// Get pricing info for fare calculation
$pricing = [];
$result = $conn->query("SELECT * FROM pricing LIMIT 1");
if ($result->num_rows === 1) {
    $pricing = $result->fetch_assoc();
}
?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="dashboard-container">
    <div class="user-info">
        <h3>Your Information</h3>
        <?php if ($user): ?>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $user['phone'] ? $user['phone'] : 'Not provided'; ?></p>
            <p><a href="edit-profile.php" class="btn">Edit Profile</a></p>
        <?php endif; ?>
    </div>
    
    <div class="create-booking">
        <h3>Book a Cab</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create_booking">
            <!-- Hidden pricing fields for JavaScript -->
            <input type="hidden" id="base_fare" value="<?php echo $pricing['base_fare'] ?? 50; ?>">
            <input type="hidden" id="per_km_rate" value="<?php echo $pricing['per_km_rate'] ?? 10; ?>">
            <input type="hidden" id="per_minute_rate" value="<?php echo $pricing['per_minute_rate'] ?? 2; ?>">
            
            <div class="form-group">
                <label for="pickup_location">Pickup Location</label>
                <input type="text" id="pickup_location" name="pickup_location" required>
            </div>
            
            <div class="form-group">
                <label for="dropoff_location">Dropoff Location</label>
                <input type="text" id="dropoff_location" name="dropoff_location" required>
            </div>
            
            <div id="fare-estimate" style="display:none;" class="fare-estimate"></div>
            
            <button type="submit" class="btn">Book Now</button>
        </form>
    </div>
    
    <div class="bookings">
        <h3>Your Bookings</h3>
        <?php if (count($bookings) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pickup</th>
                        <th>Dropoff</th>
                        <th>Time</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['pickup_location']; ?></td>
                            <td><?php echo $booking['dropoff_location']; ?></td>
                            <td><?php echo $booking['booking_time']; ?></td>
                            <td>
                                <?php if ($booking['driver_name']): ?>
                                    <?php echo $booking['driver_name']; ?> (<?php echo $booking['driver_phone']; ?>)
                                <?php else: ?>
                                    Not assigned yet
                                <?php endif; ?>
                            </td>
                            <td><?php echo ucfirst($booking['status']); ?></td>
                            <td>
                                <?php if ($booking['status'] !== 'completed' && $booking['status'] !== 'cancelled'): ?>
                                    <a href="dashboard.php?cancel=<?php echo $booking['booking_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                                    <!-- Add Edit button -->
                                    <a href="edit-booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn">Edit</a>
                                <?php endif; ?>
                                <?php if ($booking['status'] === 'completed' && !isset($booking['has_feedback'])): ?>
                                    <a href="give-feedback.php?booking=<?php echo $booking['booking_id']; ?>" class="btn">Give Feedback</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no bookings yet.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.user-info, .create-booking, .bookings {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.bookings {
    grid-column: 1 / -1;
}

.fare-estimate {
    margin: 15px 0;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
    border-left: 4px solid var(--primary-color);
}

.estimate-details {
    margin: 10px 0;
}

.estimate-details p {
    margin: 5px 0;
}

.total-fare {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #ddd;
    font-size: 1.1em;
}

.fare-disclaimer {
    margin-top: 10px;
    color: #666;
}
</style>

<script src="assets/js/fare-calculator.js"></script>

<?php require_once 'includes/footer.php'; ?>