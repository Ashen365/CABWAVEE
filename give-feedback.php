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
if (!isset($_GET['booking']) || !is_numeric($_GET['booking'])) {
    redirect('dashboard.php');
}

$booking_id = (int)$_GET['booking'];

// Check if booking belongs to user and is completed
$stmt = $conn->prepare("SELECT b.*, d.driver_id, d.name as driver_name 
                       FROM bookings b 
                       LEFT JOIN drivers d ON b.driver_id = d.driver_id 
                       WHERE b.booking_id = ? AND b.user_id = ? AND b.status = 'completed'");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    redirect('dashboard.php');
}

$booking = $result->fetch_assoc();

// Check if feedback already exists
$stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $error = "You have already provided feedback for this booking";
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    $rating = (int)$_POST['rating'];
    $comments = sanitize($_POST['comments']);
    
    // Validate inputs
    if ($rating < 1 || $rating > 5) {
        $error = "Rating must be between 1 and 5";
    } else {
        // Insert feedback into database
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, driver_id, booking_id, rating, comments) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $_SESSION['user_id'], $booking['driver_id'], $booking_id, $rating, $comments);
        
        if ($stmt->execute()) {
            $success = "Thank you for your feedback!";
        } else {
            $error = "Failed to submit feedback: " . $conn->error;
        }
    }
}
?>

<h2>Give Feedback for Booking #<?php echo $booking_id; ?></h2>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
    <p><a href="dashboard.php" class="btn">Back to Dashboard</a></p>
<?php else: ?>
    <div class="booking-details">
        <p><strong>Driver:</strong> <?php echo $booking['driver_name']; ?></p>
        <p><strong>Pickup:</strong> <?php echo $booking['pickup_location']; ?></p>
        <p><strong>Dropoff:</strong> <?php echo $booking['dropoff_location']; ?></p>
        <p><strong>Time:</strong> <?php echo $booking['booking_time']; ?></p>
    </div>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="rating">Rating (1-5 stars)</label>
            <select id="rating" name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="comments">Comments</label>
            <textarea id="comments" name="comments" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn">Submit Feedback</button>
        <a href="dashboard.php" class="btn btn-danger">Cancel</a>
    </form>
<?php endif; ?>

<style>
.booking-details {
    background-color: #f9f9f9;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}
</style>

<?php require_once 'includes/footer.php'; ?>