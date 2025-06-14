<?php
// Check if we're in admin directory and adjust paths
$isAdminDir = true;
$basePath = '../';
require_once $basePath . 'config/config.php';
require_once $basePath . 'includes/db.php';

// Check if user is admin
if (!isAdmin()) {
    redirect($basePath . 'login.php');
}

$error = '';
$success = '';

// Process form submission for editing booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'edit' && isset($_POST['booking_id'])) {
        $booking_id = (int)$_POST['booking_id'];
        $driver_id = !empty($_POST['driver_id']) ? (int)$_POST['driver_id'] : null;
        $status = sanitize($_POST['status']);
        
        // Update booking in database
        if ($driver_id) {
            $stmt = $conn->prepare("UPDATE bookings SET driver_id = ?, status = ? WHERE booking_id = ?");
            $stmt->bind_param("isi", $driver_id, $status, $booking_id);
        } else {
            $stmt = $conn->prepare("UPDATE bookings SET driver_id = NULL, status = ? WHERE booking_id = ?");
            $stmt->bind_param("si", $status, $booking_id);
        }
        
        if ($stmt->execute()) {
            $success = "Booking updated successfully";
        } else {
            $error = "Failed to update booking: " . $conn->error;
        }
    }
    // Delete booking
    elseif (isset($_POST['delete']) && isset($_POST['booking_id'])) {
        $booking_id = (int)$_POST['booking_id'];
        
        // Check if booking has any feedback
        $stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Delete associated feedback first
            $stmt = $conn->prepare("DELETE FROM feedback WHERE booking_id = ?");
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
        }
        
        // Now delete the booking
        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        
        if ($stmt->execute()) {
            $success = "Booking deleted successfully";
        } else {
            $error = "Failed to delete booking: " . $conn->error;
        }
    }
}

// Get booking for editing
$booking = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $booking_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT b.*, u.username, d.name as driver_name 
                           FROM bookings b 
                           LEFT JOIN users u ON b.user_id = u.user_id 
                           LEFT JOIN drivers d ON b.driver_id = d.driver_id 
                           WHERE b.booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $booking = $result->fetch_assoc();
    }
}

// Get all available drivers
$available_drivers = [];
$result = $conn->query("SELECT driver_id, name FROM drivers WHERE status = 'available' OR status = 'busy' ORDER BY name");
while ($row = $result->fetch_assoc()) {
    $available_drivers[] = $row;
}

// Get all bookings with user and driver info
$bookings = [];
$result = $conn->query("SELECT b.*, u.username, d.name as driver_name 
                       FROM bookings b 
                       LEFT JOIN users u ON b.user_id = u.user_id 
                       LEFT JOIN drivers d ON b.driver_id = d.driver_id 
                       ORDER BY b.booking_time DESC");
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Include header
include $basePath . 'includes/header.php';
?>

<?php if ($booking): ?>
    <h2>Edit Booking #<?php echo $booking['booking_id']; ?></h2>
    
    <?php if ($error): ?>
        <?php echo showError($error); ?>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <?php echo showSuccess($success); ?>
    <?php endif; ?>
    
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
        
        <div class="form-group">
            <label>User</label>
            <input type="text" value="<?php echo $booking['username']; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label>Pickup Location</label>
            <input type="text" value="<?php echo $booking['pickup_location']; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label>Dropoff Location</label>
            <input type="text" value="<?php echo $booking['dropoff_location']; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label>Booking Time</label>
            <input type="text" value="<?php echo $booking['booking_time']; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="driver_id">Assign Driver</label>
            <select id="driver_id" name="driver_id">
                <option value="">-- Select Driver --</option>
                <?php foreach ($available_drivers as $driver): ?>
                    <option value="<?php echo $driver['driver_id']; ?>" <?php echo ($booking['driver_id'] == $driver['driver_id']) ? 'selected' : ''; ?>>
                        <?php echo $driver['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="pending" <?php echo ($booking['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="confirmed" <?php echo ($booking['status'] === 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="completed" <?php echo ($booking['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo ($booking['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        
        <button type="submit" class="btn">Update Booking</button>
        <a href="manage-bookings.php" class="btn btn-danger">Cancel</a>
    </form>
<?php else: ?>
    <h2>Manage Bookings</h2>
    
    <?php if ($error): ?>
        <?php echo showError($error); ?>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <?php echo showSuccess($success); ?>
    <?php endif; ?>
    
    <?php if (count($bookings) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Driver</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?php echo $b['booking_id']; ?></td>
                        <td><?php echo $b['username']; ?></td>
                        <td><?php echo $b['driver_name'] ? $b['driver_name'] : 'Not Assigned'; ?></td>
                        <td><?php echo $b['pickup_location']; ?></td>
                        <td><?php echo $b['dropoff_location']; ?></td>
                        <td><?php echo $b['booking_time']; ?></td>
                        <td><?php echo ucfirst($b['status']); ?></td>
                        <td>
                            <a href="manage-bookings.php?edit=<?php echo $b['booking_id']; ?>" class="btn">Edit</a>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="booking_id" value="<?php echo $b['booking_id']; ?>">
                                <input type="hidden" name="delete" value="1">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
<?php endif; ?>

<?php include $basePath . 'includes/footer.php'; ?>