<?php
require_once 'includes/header.php';

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

<div class="dashboard-header">
    <h2><i class="fas fa-tachometer-alt"></i> Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p class="last-login">Last login: <?php echo date('Y-m-d H:i:s'); ?></p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="dashboard-container">
    <div class="user-info card">
        <div class="card-header">
            <h3><i class="fas fa-user-circle"></i> Your Information</h3>
        </div>
        <div class="card-body">
            <?php if ($user): ?>
                <div class="user-detail">
                    <span class="detail-label"><i class="fas fa-user"></i> Username:</span>
                    <span class="detail-value"><?php echo $user['username']; ?></span>
                </div>
                <div class="user-detail">
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                    <span class="detail-value"><?php echo $user['email']; ?></span>
                </div>
                <div class="user-detail">
                    <span class="detail-label"><i class="fas fa-phone"></i> Phone:</span>
                    <span class="detail-value"><?php echo $user['phone'] ? $user['phone'] : 'Not provided'; ?></span>
                </div>
                <div class="button-wrapper">
                    <a href="edit-profile.php" class="btn"><i class="fas fa-user-edit"></i> Edit Profile</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="create-booking card">
        <div class="card-header">
            <h3><i class="fas fa-taxi"></i> Book a Cab</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="action" value="create_booking">
                <!-- Hidden pricing fields for JavaScript -->
                <input type="hidden" id="base_fare" value="<?php echo $pricing['base_fare'] ?? 50; ?>">
                <input type="hidden" id="per_km_rate" value="<?php echo $pricing['per_km_rate'] ?? 10; ?>">
                <input type="hidden" id="per_minute_rate" value="<?php echo $pricing['per_minute_rate'] ?? 2; ?>">
                
                <div class="form-group">
                    <label for="pickup_location"><i class="fas fa-map-marker-alt"></i> Pickup Location</label>
                    <input type="text" id="pickup_location" name="pickup_location" required placeholder="Enter pickup address">
                </div>
                
                <div class="form-group">
                    <label for="dropoff_location"><i class="fas fa-map-pin"></i> Dropoff Location</label>
                    <input type="text" id="dropoff_location" name="dropoff_location" required placeholder="Enter destination address">
                </div>
                
                <div id="fare-estimate" style="display:none;" class="fare-estimate">
                    <div class="estimate-title"><i class="fas fa-receipt"></i> Fare Estimate</div>
                    <div id="estimate-details" class="estimate-details"></div>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</button>
            </form>
        </div>
    </div>
    
    <div class="bookings card">
        <div class="card-header">
            <h3><i class="fas fa-history"></i> Your Bookings</h3>
        </div>
        <div class="card-body">
            <?php if (count($bookings) > 0): ?>
                <div class="table-responsive">
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
                                <tr class="booking-row status-<?php echo $booking['status']; ?>">
                                    <td><span class="booking-id">#<?php echo $booking['booking_id']; ?></span></td>
                                    <td><span class="location-text"><?php echo $booking['pickup_location']; ?></span></td>
                                    <td><span class="location-text"><?php echo $booking['dropoff_location']; ?></span></td>
                                    <td><?php echo date('M d, H:i', strtotime($booking['booking_time'])); ?></td>
                                    <td>
                                        <?php if ($booking['driver_name']): ?>
                                            <span class="driver-info">
                                                <i class="fas fa-user-tie"></i> <?php echo $booking['driver_name']; ?><br>
                                                <small><i class="fas fa-phone-alt"></i> <?php echo $booking['driver_phone']; ?></small>
                                            </span>
                                        <?php else: ?>
                                            <span class="awaiting">Not assigned yet</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $booking['status']; ?>">
                                            <?php 
                                            $icon = '';
                                            switch($booking['status']) {
                                                case 'pending': $icon = '<i class="fas fa-clock"></i>'; break;
                                                case 'confirmed': $icon = '<i class="fas fa-check-circle"></i>'; break;
                                                case 'in_progress': $icon = '<i class="fas fa-car-side"></i>'; break;
                                                case 'completed': $icon = '<i class="fas fa-check-double"></i>'; break;
                                                case 'cancelled': $icon = '<i class="fas fa-times-circle"></i>'; break;
                                                default: $icon = '<i class="fas fa-question-circle"></i>';
                                            }
                                            echo $icon . ' ' . ucfirst(str_replace('_', ' ', $booking['status'])); 
                                            ?>
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <?php if ($booking['status'] !== 'completed' && $booking['status'] !== 'cancelled'): ?>
                                            <a href="dashboard.php?cancel=<?php echo $booking['booking_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                            <a href="edit-booking.php?id=<?php echo $booking['booking_id']; ?>" class="btn btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($booking['status'] === 'completed' && !isset($booking['has_feedback'])): ?>
                                            <a href="give-feedback.php?booking=<?php echo $booking['booking_id']; ?>" class="btn btn-sm btn-success">
                                                <i class="fas fa-star"></i> Rate
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-car-side empty-icon"></i>
                    <p>You have no bookings yet.</p>
                    <p class="empty-action">Use the form above to book your first ride!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
.dashboard-header {
    margin-bottom: 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding-bottom: 15px;
}

.dashboard-header h2 {
    color: var(--dark-color);
    font-size: 1.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.dashboard-header h2 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.last-login {
    font-size: 0.9rem;
    color: var(--gray-color);
    margin-top: 5px;
}

.dashboard-container {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 25px;
    margin-bottom: 50px;
}

.card {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.card-header {
    padding: 20px;
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.card-header h3 i {
    margin-right: 10px;
}

.card-body {
    padding: 25px;
}

/* User Info Card */
.user-detail {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.detail-label {
    font-weight: 500;
    width: 100px;
    color: var(--dark-color);
    display: flex;
    align-items: center;
}

.detail-label i {
    margin-right: 8px;
    color: var(--primary-color);
    width: 20px;
    text-align: center;
}

.detail-value {
    color: var(--text-color);
}

.button-wrapper {
    margin-top: 20px;
}

/* Create Booking Card */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-group label i {
    margin-right: 8px;
    color: var(--primary-color);
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    outline: none;
}

.fare-estimate {
    background-color: rgba(67, 97, 238, 0.05);
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    border-left: 3px solid var(--primary-color);
}

.estimate-title {
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.estimate-title i {
    margin-right: 8px;
}

.estimate-details p {
    margin: 5px 0;
    display: flex;
    justify-content: space-between;
}

.total-fare {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    font-weight: 600;
    font-size: 1.1em;
    display: flex;
    justify-content: space-between;
}

/* Bookings Table */
.bookings {
    grid-column: 1 / -1;
}

.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

table th {
    background-color: rgba(67, 97, 238, 0.08);
    color: var(--dark-color);
    font-weight: 600;
    text-align: left;
    padding: 15px;
    border-bottom: 2px solid rgba(67, 97, 238, 0.2);
}

table td {
    padding: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.booking-row {
    transition: background-color 0.3s ease;
}

.booking-row:hover {
    background-color: rgba(67, 97, 238, 0.03);
}

.booking-id {
    font-weight: 600;
    color: var(--primary-color);
}

.location-text {
    display: block;
    max-width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.driver-info {
    display: block;
}

.awaiting {
    color: #888;
    font-style: italic;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-badge i {
    margin-right: 5px;
}

.status-pending {
    background-color: #fff8e1;
    color: #f57c00;
}

.status-confirmed {
    background-color: #e3f2fd;
    color: #1976d2;
}

.status-in_progress {
    background-color: #e0f7fa;
    color: #0097a7;
}

.status-completed {
    background-color: #e8f5e9;
    color: #388e3c;
}

.status-cancelled {
    background-color: #ffebee;
    color: #d32f2f;
}

.actions-cell {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.85rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 30px 0;
    color: var(--gray-color);
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #cbd5e1;
}

.empty-action {
    margin-top: 10px;
    font-style: italic;
}

/* Buttons */
.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn i {
    margin-right: 8px;
}

.btn-primary {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    border: none;
    padding: 12px 25px;
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    transform: translateY(-2px);
}

.btn-danger {
    background-color: var(--danger-color);
    color: white;
}

.btn-success {
    background-color: var(--success-color);
    color: white;
}

/* Responsive */
@media (max-width: 992px) {
    .dashboard-container {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .card-body {
        padding: 20px 15px;
    }
    
    table th, table td {
        padding: 10px 8px;
    }
    
    .location-text {
        max-width: 100px;
    }
    
    .status-badge {
        padding: 4px 8px;
        font-size: 0.8rem;
    }
    
    .actions-cell {
        flex-direction: column;
    }
}

/* Animation for fare estimate */
@keyframes highlightFare {
    0% { background-color: rgba(67, 97, 238, 0.05); }
    50% { background-color: rgba(67, 97, 238, 0.2); }
    100% { background-color: rgba(67, 97, 238, 0.05); }
}

.highlight-fare {
    animation: highlightFare 1.5s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fare calculator functionality
    const pickupLocationInput = document.getElementById('pickup_location');
    const dropoffLocationInput = document.getElementById('dropoff_location');
    const fareEstimateDiv = document.getElementById('fare-estimate');
    const estimateDetailsDiv = document.getElementById('estimate-details');
    const baseFare = parseFloat(document.getElementById('base_fare').value);
    const perKmRate = parseFloat(document.getElementById('per_km_rate').value);
    const perMinuteRate = parseFloat(document.getElementById('per_minute_rate').value);
    
    // Function to calculate and display fare estimate
    function calculateFare() {
        if (pickupLocationInput.value && dropoffLocationInput.value) {
            // In a real app, this would use a Maps API to calculate distance and time
            // For demo purposes, we'll use random values
            const distance = Math.floor(Math.random() * 15) + 2; // 2-17 km
            const time = Math.floor(distance * 2) + 5; // Estimate time based on distance + 5 min
            
            const distanceCost = distance * perKmRate;
            const timeCost = time * perMinuteRate;
            const totalFare = baseFare + distanceCost + timeCost;
            
            // Create estimate details HTML
            let html = `
                <p><span>Base fare:</span> <span>$${baseFare.toFixed(2)}</span></p>
                <p><span>Distance (${distance} km):</span> <span>$${distanceCost.toFixed(2)}</span></p>
                <p><span>Time (${time} min):</span> <span>$${timeCost.toFixed(2)}</span></p>
                <div class="total-fare"><span>Estimated total:</span> <span>$${totalFare.toFixed(2)}</span></div>
                <p class="fare-disclaimer">*This is an estimate. Actual fare may vary.</p>
            `;
            
            estimateDetailsDiv.innerHTML = html;
            fareEstimateDiv.style.display = 'block';
            
            // Add highlight animation
            fareEstimateDiv.classList.add('highlight-fare');
            setTimeout(() => {
                fareEstimateDiv.classList.remove('highlight-fare');
            }, 1500);
        }
    }
    
    // Calculate fare when destination is entered
    dropoffLocationInput.addEventListener('blur', calculateFare);
    
    // Add smooth scroll for mobile
    const tableContainer = document.querySelector('.table-responsive');
    if (tableContainer && window.innerWidth < 768) {
        tableContainer.style.cssText = 'overflow-x: auto; -webkit-overflow-scrolling: touch;';
    }
    
    // GSAP animations if available
    if (typeof gsap !== 'undefined') {
        gsap.from('.card', {
            duration: 0.6,
            y: 30,
            opacity: 0,
            stagger: 0.2,
            ease: 'power2.out'
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>