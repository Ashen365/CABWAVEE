<?php
require_once 'includes/header.php';

$error = '';
$result = null;

// Get pricing information from database
$pricing_query = $conn->query("SELECT * FROM pricing LIMIT 1");
$pricing = $pricing_query->fetch_assoc();

// Process calculation request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = sanitize($_POST['pickup']);
    $dropoff = sanitize($_POST['dropoff']);
    
    // Validate inputs
    if (empty($pickup) || empty($dropoff)) {
        $error = "Both pickup and dropoff locations are required";
    } else {
        // In a real-world application, you would use Google Maps Distance Matrix API or similar
        // to calculate the actual distance and estimated time. For this demo, we'll simulate it.
        
        // Generate a random distance between 1 and 30 km
        $distance = mt_rand(1 * 10, 30 * 10) / 10; // To get 1 decimal place
        
        // Estimate time: assume average speed of 30 km/h
        $estimated_time = ceil($distance / 30 * 60); // in minutes
        
        // Calculate fare components
        $base_fare = $pricing['base_fare'];
        $distance_charge = $distance * $pricing['per_km_rate'];
        $time_charge = $estimated_time * $pricing['per_minute_rate'];
        
        // Total fare
        $total_fare = $base_fare + $distance_charge + $time_charge;
        
        // Prepare result
        $result = [
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'distance' => $distance,
            'estimated_time' => $estimated_time,
            'base_fare' => $base_fare,
            'distance_charge' => $distance_charge,
            'time_charge' => $time_charge,
            'total_fare' => $total_fare
        ];
    }
}
?>

<div class="page-header">
    <h2>Fare Calculator</h2>
    <p>Estimate the cost of your ride before booking</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<div class="calculator-container">
    <div class="calculator-form">
        <h3>Enter Trip Details</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="pickup">Pickup Location</label>
                <input type="text" id="pickup" name="pickup" required value="<?php echo isset($_POST['pickup']) ? htmlspecialchars($_POST['pickup']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="dropoff">Dropoff Location</label>
                <input type="text" id="dropoff" name="dropoff" required value="<?php echo isset($_POST['dropoff']) ? htmlspecialchars($_POST['dropoff']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Service Type</label>
                <div class="service-options">
                    <label class="radio-container">
                        <input type="radio" name="service_type" value="standard" checked> Standard
                        <span class="radio-checkmark"></span>
                    </label>
                    <label class="radio-container">
                        <input type="radio" name="service_type" value="premium"> Premium
                        <span class="radio-checkmark"></span>
                    </label>
                    <label class="radio-container">
                        <input type="radio" name="service_type" value="suv"> SUV/Minivan
                        <span class="radio-checkmark"></span>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn">Calculate Fare</button>
        </form>
    </div>
    
    <?php if ($result): ?>
    <div class="calculator-result">
        <h3>Fare Estimate</h3>
        <div class="trip-details">
            <div class="detail-item">
                <span class="detail-label">From:</span>
                <span class="detail-value"><?php echo htmlspecialchars($result['pickup']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">To:</span>
                <span class="detail-value"><?php echo htmlspecialchars($result['dropoff']); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Distance:</span>
                <span class="detail-value"><?php echo $result['distance']; ?> km</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Estimated Time:</span>
                <span class="detail-value"><?php echo $result['estimated_time']; ?> minutes</span>
            </div>
        </div>
        
        <div class="fare-breakdown">
            <h4>Fare Breakdown</h4>
            <div class="breakdown-item">
                <span class="breakdown-label">Base Fare:</span>
                <span class="breakdown-value">₹<?php echo number_format($result['base_fare'], 2); ?></span>
            </div>
            <div class="breakdown-item">
                <span class="breakdown-label">Distance Charge (<?php echo $result['distance']; ?> km × ₹<?php echo $pricing['per_km_rate']; ?>):</span>
                <span class="breakdown-value">₹<?php echo number_format($result['distance_charge'], 2); ?></span>
            </div>
            <div class="breakdown-item">
                <span class="breakdown-label">Time Charge (<?php echo $result['estimated_time']; ?> min × ₹<?php echo $pricing['per_minute_rate']; ?>):</span>
                <span class="breakdown-value">₹<?php echo number_format($result['time_charge'], 2); ?></span>
            </div>
            <div class="breakdown-total">
                <span class="breakdown-label">Total Estimated Fare:</span>
                <span class="breakdown-value">₹<?php echo number_format($result['total_fare'], 2); ?></span>
            </div>
        </div>
        
        <div class="fare-note">
            <p><strong>Note:</strong> This is an estimated fare. Actual fare may vary based on traffic, route taken, and waiting time.</p>
        </div>
        
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div class="pricing-info">
    <h3>Our Pricing</h3>
    <div class="pricing-details">
        <div class="pricing-item">
            <h4>Base Fare</h4>
            <p>₹<?php echo $pricing['base_fare']; ?></p>
            <small>Starting fare for all rides</small>
        </div>
        
        <div class="pricing-item">
            <h4>Per Kilometer</h4>
            <p>₹<?php echo $pricing['per_km_rate']; ?></p>
            <small>Rate charged per kilometer traveled</small>
        </div>
        
        <div class="pricing-item">
            <h4>Per Minute</h4>
            <p>₹<?php echo $pricing['per_minute_rate']; ?></p>
            <small>Rate charged per minute of travel time</small>
        </div>
    </div>
    
    <div class="pricing-services">
        <h4>Service Multipliers</h4>
        <ul>
            <li><strong>Standard:</strong> 1× (base price)</li>
            <li><strong>Premium:</strong> 1.5× (50% extra)</li>
            <li><strong>SUV/Minivan:</strong> 2× (double price)</li>
        </ul>
        <p><a href="services.php">View all our services</a></p>
    </div>
</div>

<style>
.calculator-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.calculator-form, .calculator-result, .pricing-info {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
}

.service-options {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 10px;
}

.radio-container {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 30px;
    cursor: pointer;
    user-select: none;
    margin-right: 15px;
}

.radio-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.radio-checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #f0f0f0;
    border-radius: 50%;
}

.radio-container:hover input ~ .radio-checkmark {
    background-color: #e0e0e0;
}

.radio-container input:checked ~ .radio-checkmark {
    background-color: var(--primary-color);
}

.radio-checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.radio-container input:checked ~ .radio-checkmark:after {
    display: block;
}

.radio-container .radio-checkmark:after {
    top: 6px;
    left: 6px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}

.trip-details, .fare-breakdown {
    margin-bottom: 20px;
}

.detail-item, .breakdown-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.breakdown-total {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    margin-top: 10px;
    border-top: 2px solid var(--primary-color);
    font-weight: bold;
    font-size: 1.1em;
}

.detail-label, .breakdown-label {
    color: #666;
}

.detail-value, .breakdown-value {
    font-weight: 500;
}

.fare-note {
    margin: 20px 0;
    padding: 15px;
    background-color: #f9f9f9;
    border-left: 4px solid var(--primary-color);
    border-radius: 4px;
}

.pricing-info {
    grid-column: 1 / -1;
    margin-bottom: 30px;
}

.pricing-details {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 20px 0;
}

.pricing-item {
    flex: 1;
    min-width: 200px;
    margin: 10px;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
    text-align: center;
}

.pricing-item h4 {
    margin-bottom: 10px;
    color: var(--primary-color);
}

.pricing-item p {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.pricing-services {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
}

.pricing-services ul {
    padding-left: 20px;
    margin: 10px 0;
}

@media (max-width: 768px) {
    .calculator-container {
        grid-template-columns: 1fr;
    }
    
    .service-options {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>