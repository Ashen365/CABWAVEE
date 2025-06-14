<?php
// Check if we're in admin directory and adjust paths
$basePath = '../';
require_once $basePath . 'config/config.php';
require_once $basePath . 'includes/db.php';

// Check if user is admin
if (!isAdmin()) {
    redirect($basePath . 'login.php');
}

// Get stats
$stats = [
    'users' => 0,
    'drivers' => 0,
    'bookings' => 0,
    'pending_bookings' => 0,
    'completed_bookings' => 0
];

$result = $conn->query("SELECT COUNT(*) as count FROM users");
$stats['users'] = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM drivers");
$stats['drivers'] = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM bookings");
$stats['bookings'] = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'");
$stats['pending_bookings'] = $result->fetch_assoc()['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'completed'");
$stats['completed_bookings'] = $result->fetch_assoc()['count'];

// Get recent bookings
$recent_bookings = [];
$result = $conn->query("SELECT b.*, u.username, d.name as driver_name 
                       FROM bookings b 
                       LEFT JOIN users u ON b.user_id = u.user_id 
                       LEFT JOIN drivers d ON b.driver_id = d.driver_id 
                       ORDER BY b.booking_time DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $recent_bookings[] = $row;
}

// Include header
include $basePath . 'includes/header.php';
?>

<h2>Admin Dashboard</h2>

<div class="stats-container">
    <div class="stat-box">
        <h3>Total Users</h3>
        <p class="stat-value"><?php echo $stats['users']; ?></p>
    </div>
    
    <div class="stat-box">
        <h3>Total Drivers</h3>
        <p class="stat-value"><?php echo $stats['drivers']; ?></p>
    </div>
    
    <div class="stat-box">
        <h3>Total Bookings</h3>
        <p class="stat-value"><?php echo $stats['bookings']; ?></p>
    </div>
    
    <div class="stat-box">
        <h3>Pending Bookings</h3>
        <p class="stat-value"><?php echo $stats['pending_bookings']; ?></p>
    </div>
    
    <div class="stat-box">
        <h3>Completed Bookings</h3>
        <p class="stat-value"><?php echo $stats['completed_bookings']; ?></p>
    </div>
</div>

<div class="admin-links">
    <a href="manage-drivers.php" class="btn">Manage Drivers</a>
    <a href="manage-bookings.php" class="btn">Manage Bookings</a>
    <a href="settings.php" class="btn">Settings</a>
</div>

<h3>Recent Bookings</h3>
<?php if (count($recent_bookings) > 0): ?>
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['booking_id']; ?></td>
                    <td><?php echo $booking['username']; ?></td>
                    <td><?php echo $booking['driver_name'] ? $booking['driver_name'] : 'Not Assigned'; ?></td>
                    <td><?php echo $booking['pickup_location']; ?></td>
                    <td><?php echo $booking['dropoff_location']; ?></td>
                    <td><?php echo $booking['booking_time']; ?></td>
                    <td><?php echo ucfirst($booking['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="manage-bookings.php" class="btn">View All Bookings</a></p>
<?php else: ?>
    <p>No recent bookings found.</p>
<?php endif; ?>

<style>
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.stat-box {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-color);
}

.admin-links {
    margin: 20px 0;
}

.admin-links .btn {
    margin-right: 10px;
}
</style>

<?php include $basePath . 'includes/footer.php'; ?>