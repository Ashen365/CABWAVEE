<?php
require_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';
$booking = null;

// Check if booking ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('dashboard.php');
}

$booking_id = (int)$_GET['id'];

// Check if booking belongs to user and is not completed or cancelled
$stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ? AND user_id = ? AND (status = 'pending' OR status = 'confirmed')");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // If no booking found or not editable, redirect to dashboard
    $_SESSION['error'] = "Booking not found or cannot be edited";
    redirect('dashboard.php');
}

$booking = $result->fetch_assoc();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup_location = sanitize($_POST['pickup_location']);
    $dropoff_location = sanitize($_POST['dropoff_location']);
    
    // Validate inputs
    if (empty($pickup_location) || empty($dropoff_location)) {
        $error = "Pickup and dropoff locations are required";
    } else {
        // Update booking in database
        $stmt = $conn->prepare("UPDATE bookings SET pickup_location = ?, dropoff_location = ? WHERE booking_id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $pickup_location, $dropoff_location, $booking_id, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $success = "Booking updated successfully";
            // Refresh booking data
            $stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ?");
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $booking = $stmt->get_result()->fetch_assoc();
        } else {
            $error = "Failed to update booking: " . $conn->error;
        }
    }
}
?>

<div class="page-header">
    <h2>Edit Booking #<?php echo $booking_id; ?></h2>
    <p>Update your booking details</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="edit-booking-container">
    <form method="POST" action="">
        <div class="form-group">
            <label for="pickup_location">Pickup Location</label>
            <input type="text" id="pickup_location" name="pickup_location" value="<?php echo htmlspecialchars($booking['pickup_location']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="dropoff_location">Dropoff Location</label>
            <input type="text" id="dropoff_location" name="dropoff_location" value="<?php echo htmlspecialchars($booking['dropoff_location']); ?>" required>
        </div>
        
        <div class="booking-info">
            <p><strong>Booking Time:</strong> <?php echo $booking['booking_time']; ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($booking['status']); ?></p>
            <p class="booking-note">Note: You can only modify pickup and dropoff locations. If you need to change other details, please cancel this booking and create a new one.</p>
        </div>
        
        <div class="form-buttons">
            <button type="submit" class="btn">Update Booking</button>
            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<style>
.edit-booking-container {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
}

.booking-info {
    margin: 20px 0;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

.booking-note {
    margin-top: 15px;
    font-style: italic;
    color: #666;
}

.form-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}
</style>

<?php require_once 'includes/footer.php'; ?>