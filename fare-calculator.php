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
    $service_type = sanitize($_POST['service_type']);
    
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
        
        // Apply service multiplier
        $multiplier = 1;
        if ($service_type == 'premium') {
            $multiplier = 1.5;
        } elseif ($service_type == 'suv') {
            $multiplier = 2;
        }
        
        // Total fare
        $subtotal = $base_fare + $distance_charge + $time_charge;
        $total_fare = $subtotal * $multiplier;
        
        // Prepare result
        $result = [
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'service_type' => $service_type,
            'distance' => $distance,
            'estimated_time' => $estimated_time,
            'base_fare' => $base_fare,
            'distance_charge' => $distance_charge,
            'time_charge' => $time_charge,
            'subtotal' => $subtotal,
            'multiplier' => $multiplier,
            'total_fare' => $total_fare
        ];
    }
}
?>

<div class="page-header">
    <h2><i class="fas fa-calculator"></i> Fare Calculator</h2>
    <p>Estimate the cost of your ride before booking</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<div class="calculator-container">
    <div class="calculator-form card">
        <div class="card-header">
            <h3><i class="fas fa-map-marked-alt"></i> Enter Trip Details</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="pickup"><i class="fas fa-map-marker-alt"></i> Pickup Location</label>
                    <input type="text" id="pickup" name="pickup" required placeholder="Enter pickup address" value="<?php echo isset($_POST['pickup']) ? htmlspecialchars($_POST['pickup']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="dropoff"><i class="fas fa-map-pin"></i> Dropoff Location</label>
                    <input type="text" id="dropoff" name="dropoff" required placeholder="Enter destination address" value="<?php echo isset($_POST['dropoff']) ? htmlspecialchars($_POST['dropoff']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-car-alt"></i> Service Type</label>
                    <div class="service-options">
                        <label class="service-option">
                            <input type="radio" name="service_type" value="standard" <?php echo (!isset($_POST['service_type']) || $_POST['service_type'] == 'standard') ? 'checked' : ''; ?>>
                            <span class="service-card">
                                <span class="service-icon"><i class="fas fa-taxi"></i></span>
                                <span class="service-name">Standard</span>
                                <span class="service-price">1× base fare</span>
                            </span>
                        </label>
                        <label class="service-option">
                            <input type="radio" name="service_type" value="premium" <?php echo (isset($_POST['service_type']) && $_POST['service_type'] == 'premium') ? 'checked' : ''; ?>>
                            <span class="service-card">
                                <span class="service-icon"><i class="fas fa-car"></i></span>
                                <span class="service-name">Premium</span>
                                <span class="service-price">1.5× base fare</span>
                            </span>
                        </label>
                        <label class="service-option">
                            <input type="radio" name="service_type" value="suv" <?php echo (isset($_POST['service_type']) && $_POST['service_type'] == 'suv') ? 'checked' : ''; ?>>
                            <span class="service-card">
                                <span class="service-icon"><i class="fas fa-shuttle-van"></i></span>
                                <span class="service-name">SUV/Minivan</span>
                                <span class="service-price">2× base fare</span>
                            </span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Calculate Fare</button>
            </form>
        </div>
    </div>
    
    <?php if ($result): ?>
    <div class="calculator-result card">
        <div class="card-header">
            <h3><i class="fas fa-receipt"></i> Fare Estimate</h3>
        </div>
        <div class="card-body">
            <div class="trip-summary">
                <div class="route-visual">
                    <div class="route-point start"><i class="fas fa-dot-circle"></i></div>
                    <div class="route-line"></div>
                    <div class="route-point end"><i class="fas fa-map-marker-alt"></i></div>
                </div>
                <div class="route-details">
                    <div class="location pickup">
                        <div class="location-label">From</div>
                        <div class="location-value"><?php echo htmlspecialchars($result['pickup']); ?></div>
                    </div>
                    <div class="location dropoff">
                        <div class="location-label">To</div>
                        <div class="location-value"><?php echo htmlspecialchars($result['dropoff']); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="trip-stats">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-route"></i></div>
                    <div class="stat-value"><?php echo $result['distance']; ?> km</div>
                    <div class="stat-label">Distance</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-value"><?php echo $result['estimated_time']; ?> min</div>
                    <div class="stat-label">Est. Time</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <?php 
                        $icon = 'fas fa-taxi';
                        if($result['service_type'] == 'premium') {
                            $icon = 'fas fa-car';
                        } elseif($result['service_type'] == 'suv') {
                            $icon = 'fas fa-shuttle-van';
                        }
                        ?>
                        <i class="<?php echo $icon; ?>"></i>
                    </div>
                    <div class="stat-value"><?php echo ucfirst($result['service_type']); ?></div>
                    <div class="stat-label">Service</div>
                </div>
            </div>
            
            <div class="fare-breakdown">
                <h4>Fare Breakdown</h4>
                <div class="breakdown-item">
                    <span class="breakdown-label">Base Fare</span>
                    <span class="breakdown-value">₹<?php echo number_format($result['base_fare'], 2); ?></span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Distance Charge <small>(<?php echo $result['distance']; ?> km × ₹<?php echo $pricing['per_km_rate']; ?>)</small></span>
                    <span class="breakdown-value">₹<?php echo number_format($result['distance_charge'], 2); ?></span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Time Charge <small>(<?php echo $result['estimated_time']; ?> min × ₹<?php echo $pricing['per_minute_rate']; ?>)</small></span>
                    <span class="breakdown-value">₹<?php echo number_format($result['time_charge'], 2); ?></span>
                </div>
                
                <div class="breakdown-subtotal">
                    <span class="breakdown-label">Subtotal</span>
                    <span class="breakdown-value">₹<?php echo number_format($result['subtotal'], 2); ?></span>
                </div>
                
                <?php if($result['multiplier'] > 1): ?>
                <div class="breakdown-item service-multiplier">
                    <span class="breakdown-label"><?php echo ucfirst($result['service_type']); ?> service <small>(<?php echo $result['multiplier']; ?>× multiplier)</small></span>
                    <span class="breakdown-value">×<?php echo $result['multiplier']; ?></span>
                </div>
                <?php endif; ?>
                
                <div class="breakdown-total">
                    <span class="breakdown-label">Total Estimated Fare</span>
                    <span class="breakdown-value">₹<?php echo number_format($result['total_fare'], 2); ?></span>
                </div>
            </div>
            
            <div class="fare-note">
                <i class="fas fa-info-circle"></i>
                <p>This is an estimated fare. Actual fare may vary based on traffic conditions, route taken, and waiting time.</p>
            </div>
            
            <div class="booking-action">
                <?php if(isLoggedIn()): ?>
                    <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book This Ride</a>
                <?php else: ?>
                    <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="pricing-info">
    <h3><i class="fas fa-tags"></i> Our Pricing</h3>
    <p>We offer transparent pricing with no hidden charges</p>
    
    <div class="pricing-details">
        <div class="pricing-item">
            <div class="pricing-icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <h4>Base Fare</h4>
            <div class="pricing-value">₹<?php echo $pricing['base_fare']; ?></div>
            <div class="pricing-description">Starting fare for all rides</div>
        </div>
        
        <div class="pricing-item">
            <div class="pricing-icon">
                <i class="fas fa-road"></i>
            </div>
            <h4>Per Kilometer</h4>
            <div class="pricing-value">₹<?php echo $pricing['per_km_rate']; ?></div>
            <div class="pricing-description">Rate charged per kilometer traveled</div>
        </div>
        
        <div class="pricing-item">
            <div class="pricing-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <h4>Per Minute</h4>
            <div class="pricing-value">₹<?php echo $pricing['per_minute_rate']; ?></div>
            <div class="pricing-description">Rate charged per minute of travel time</div>
        </div>
    </div>
    
    <div class="service-multipliers">
        <h4><i class="fas fa-percent"></i> Service Multipliers</h4>
        <div class="multipliers-grid">
            <div class="multiplier-item standard">
                <div class="multiplier-icon"><i class="fas fa-taxi"></i></div>
                <div class="multiplier-name">Standard</div>
                <div class="multiplier-value">1×</div>
                <div class="multiplier-description">Base price</div>
            </div>
            
            <div class="multiplier-item premium">
                <div class="multiplier-icon"><i class="fas fa-car"></i></div>
                <div class="multiplier-name">Premium</div>
                <div class="multiplier-value">1.5×</div>
                <div class="multiplier-description">50% extra</div>
            </div>
            
            <div class="multiplier-item suv">
                <div class="multiplier-icon"><i class="fas fa-shuttle-van"></i></div>
                <div class="multiplier-name">SUV/Minivan</div>
                <div class="multiplier-value">2×</div>
                <div class="multiplier-description">Double price</div>
            </div>
        </div>
        
        <div class="pricing-cta">
            <a href="services.php" class="btn"><i class="fas fa-th-list"></i> View All Our Services</a>
        </div>
    </div>
</div>

<style>
/* Page Header */
.page-header {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    padding-bottom: 20px;
}

.page-header h2 {
    color: var(--dark-color);
    font-size: 2.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-header h2 i {
    margin-right: 15px;
    color: var(--primary-color);
}

.page-header p {
    color: var(--gray-color);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

.page-header::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

/* Calculator Container */
.calculator-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

/* Card Styling */
.card {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.card-header {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    padding: 20px 25px;
}

.card-header h3 {
    margin: 0;
    font-size: 1.4rem;
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

/* Form Styling */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: flex;
    align-items: center;
    font-weight: 500;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.form-group label i {
    margin-right: 10px;
    color: var(--primary-color);
    width: 18px;
    text-align: center;
}

input[type="text"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

input[type="text"]:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    outline: none;
}

input[type="text"]::placeholder {
    color: #a0aec0;
}

/* Service Options */
.service-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.service-option {
    position: relative;
    cursor: pointer;
}

.service-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.service-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 10px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-align: center;
}

.service-option input[type="radio"]:checked + .service-card {
    border-color: var(--primary-color);
    background-color: rgba(67, 97, 238, 0.05);
    box-shadow: 0 3px 10px rgba(67, 97, 238, 0.1);
}

.service-icon {
    font-size: 1.8rem;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.service-name {
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--dark-color);
}

.service-price {
    font-size: 0.85rem;
    color: var(--gray-color);
}

/* Button */
.btn {
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
}

.btn i {
    margin-right: 8px;
}

.btn-primary {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    transform: translateY(-2px);
}

/* Trip Summary */
.trip-summary {
    display: flex;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.route-visual {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 20px;
    padding-top: 5px;
}

.route-point {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    position: relative;
    z-index: 1;
}

.route-line {
    width: 2px;
    height: 40px;
    background-color: var(--primary-color);
    margin: 5px 0;
}

.route-details {
    flex: 1;
}

.location {
    margin-bottom: 20px;
}

.location-label {
    font-size: 0.9rem;
    color: var(--gray-color);
    margin-bottom: 5px;
}

.location-value {
    font-weight: 500;
    color: var(--dark-color);
}

/* Trip Stats */
.trip-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.stat-icon {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 8px;
    width: 50px;
    height: 50px;
    background-color: rgba(67, 97, 238, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-value {
    font-weight: 600;
    font-size: 1.2rem;
    color: var(--dark-color);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-color);
}

/* Fare Breakdown */
.fare-breakdown {
    margin-bottom: 25px;
}

.fare-breakdown h4 {
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: var(--dark-color);
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
}

.breakdown-label {
    color: var(--text-color);
    display: flex;
    align-items: center;
}

.breakdown-label small {
    margin-left: 5px;
    color: var(--gray-color);
    font-size: 0.85rem;
}

.breakdown-value {
    font-weight: 500;
    color: var(--dark-color);
}

.breakdown-subtotal {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-top: 1px dashed rgba(0, 0, 0, 0.1);
    border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
    margin: 10px 0;
    font-weight: 500;
}

.service-multiplier {
    background-color: rgba(67, 97, 238, 0.05);
    padding: 10px 15px;
    border-radius: 8px;
    margin: 5px 0;
}

.breakdown-total {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    margin-top: 15px;
    background-color: rgba(67, 97, 238, 0.05);
    padding: 15px;
    border-radius: 8px;
}

.breakdown-total .breakdown-label {
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--dark-color);
}

.breakdown-total .breakdown-value {
    font-weight: 700;
    font-size: 1.3rem;
    color: var(--primary-color);
}

/* Fare Note */
.fare-note {
    margin: 25px 0;
    padding: 15px;
    background-color: rgba(255, 159, 28, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
}

.fare-note i {
    color: #FF9F1C;
    margin-right: 10px;
    margin-top: 3px;
}

.fare-note p {
    margin: 0;
    color: var(--text-color);
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Booking Action */
.booking-action {
    text-align: center;
    margin-top: 30px;
}

.booking-action .btn {
    padding: 14px 30px;
    font-size: 1.1rem;
    min-width: 200px;
}

/* Pricing Info */
.pricing-info {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    padding: 40px;
    margin-bottom: 50px;
    text-align: center;
}

.pricing-info h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    justify-content: center;
}

.pricing-info h3 i {
    margin-right: 12px;
    color: var(--primary-color);
}

.pricing-info > p {
    color: var(--gray-color);
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Pricing Details */
.pricing-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.pricing-item {
    background-color: rgba(67, 97, 238, 0.03);
    border-radius: 12px;
    padding: 30px 20px;
    transition: transform 0.3s ease;
}

.pricing-item:hover {
    transform: translateY(-5px);
}

.pricing-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-color), #5a74f1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 1.8rem;
    color: white;
}

.pricing-item h4 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: var(--dark-color);
}

.pricing-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.pricing-description {
    color: var(--gray-color);
    font-size: 0.9rem;
}

/* Service Multipliers */
.service-multipliers {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.service-multipliers h4 {
    font-size: 1.4rem;
    margin-bottom: 30px;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-multipliers h4 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.multipliers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.multiplier-item {
    background-color: white;
    border-radius: 12px;
    padding: 25px 20px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease;
}

.multiplier-item:hover {
    transform: translateY(-5px);
}

.multiplier-icon {
    font-size: 2rem;
    margin-bottom: 15px;
    color: var(--primary-color);
}

.multiplier-name {
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.multiplier-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.multiplier-description {
    color: var(--gray-color);
    font-size: 0.9rem;
}

/* Premium and SUV Styling */
.multiplier-item.premium .multiplier-icon {
    color: #5a74f1;
}

.multiplier-item.premium .multiplier-value {
    color: #5a74f1;
}

.multiplier-item.suv .multiplier-icon {
    color: var(--secondary-color);
}

.multiplier-item.suv .multiplier-value {
    color: var(--secondary-color);
}

/* Pricing CTA */
.pricing-cta {
    margin-top: 30px;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .calculator-container {
        grid-template-columns: 1fr;
    }
    
    .pricing-details {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 1.8rem;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .service-options {
        grid-template-columns: 1fr;
    }
    
    .trip-stats {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .trip-summary {
        flex-direction: column;
    }
    
    .route-visual {
        flex-direction: row;
        margin-right: 0;
        margin-bottom: 20px;
    }
    
    .route-line {
        width: 40px;
        height: 2px;
        margin: 0 5px;
    }
    
    .pricing-details,
    .multipliers-grid {
        grid-template-columns: 1fr;
    }
    
    .pricing-info {
        padding: 30px 20px;
    }
}

/* Animation Classes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.slide-up {
    animation: slideUp 0.8s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // GSAP animations if available
    if (typeof gsap !== 'undefined') {
        // Page header animation
        gsap.from('.page-header h2, .page-header p', {
            duration: 1,
            y: 30,
            opacity: 0,
            stagger: 0.3,
            ease: 'power3.out'
        });
        
        // Form and result card animations
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            
            gsap.from('.calculator-form', {
                scrollTrigger: {
                    trigger: '.calculator-container',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.calculator-result', {
                scrollTrigger: {
                    trigger: '.calculator-result',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 0.2,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-info', {
                scrollTrigger: {
                    trigger: '.pricing-info',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-item', {
                scrollTrigger: {
                    trigger: '.pricing-details',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.2,
                ease: 'power2.out'
            });
            
            gsap.from('.multiplier-item', {
                scrollTrigger: {
                    trigger: '.multipliers-grid',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.15,
                ease: 'power2.out'
            });
        } else {
            // Fallback animations without ScrollTrigger
            gsap.from('.calculator-form', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 0.5,
                ease: 'power2.out'
            });
            
            if (document.querySelector('.calculator-result')) {
                gsap.from('.calculator-result', {
                    duration: 0.8,
                    y: 30,
                    opacity: 0,
                    delay: 0.7,
                    ease: 'power2.out'
                });
            }
            
            gsap.from('.pricing-info', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 0.9,
                ease: 'power2.out'
            });
        }
    } else {
        // Fallback CSS animations
        document.querySelectorAll('.page-header h2, .page-header p').forEach(el => {
            el.classList.add('fade-in');
        });
        
        document.querySelector('.calculator-form').classList.add('slide-up');
        
        if (document.querySelector('.calculator-result')) {
            document.querySelector('.calculator-result').classList.add('slide-up');
        }
        
        document.querySelector('.pricing-info').classList.add('slide-up');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>