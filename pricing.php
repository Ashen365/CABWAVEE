<?php
require_once 'includes/header.php';

// Get pricing information from database
$pricing_query = $conn->query("SELECT * FROM pricing LIMIT 1");
$pricing = $pricing_query->fetch_assoc();
?>

<div class="page-header">
    <h2>Our Pricing</h2>
    <p>Transparent pricing with no hidden charges</p>
</div>

<div class="pricing-container">
    <div class="pricing-intro">
        <h3>How Our Pricing Works</h3>
        <p>At CABWAVE, we believe in complete transparency. Our fare is calculated based on three main components:</p>
        <ul class="pricing-components">
            <li><strong>Base Fare:</strong> A flat fee that covers the initial pickup</li>
            <li><strong>Distance Charge:</strong> A per-kilometer rate for the distance traveled</li>
            <li><strong>Time Charge:</strong> A per-minute rate for the duration of your trip</li>
        </ul>
        <p>Your total fare = Base Fare + (Distance × Per KM Rate) + (Time × Per Minute Rate)</p>
    </div>
    
    <div class="pricing-cards">
        <div class="pricing-card">
            <div class="pricing-card-header">
                <h3>Standard</h3>
                <div class="pricing-card-icon">🚕</div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label">Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'], 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'], 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Minute</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_minute_rate'], 2); ?></span>
                </div>
                <ul class="pricing-features">
                    <li>Up to 4 passengers</li>
                    <li>Air conditioning</li>
                    <li>24/7 availability</li>
                    <li>GPS tracking</li>
                </ul>
            </div>
            <div class="pricing-card-footer">
                <?php if(isLoggedIn()): ?>
                    <a href="dashboard.php" class="btn">Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="pricing-card featured">
            <div class="pricing-card-header">
                <h3>Premium</h3>
                <div class="pricing-card-icon">🚗</div>
                <div class="featured-label">Most Popular</div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label">Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'] * 1.5, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'] * 1.5, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Minute</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_minute_rate'] * 1.5, 2); ?></span>
                </div>
                <ul class="pricing-features">
                    <li>Up to 4 passengers</li>
                    <li>Luxury vehicles</li>
                    <li>Free Wi-Fi</li>
                    <li>Bottled water</li>
                    <li>Professional drivers</li>
                </ul>
            </div>
            <div class="pricing-card-footer">
                <?php if(isLoggedIn()): ?>
                    <a href="dashboard.php" class="btn">Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="pricing-card">
            <div class="pricing-card-header">
                <h3>SUV/Minivan</h3>
                <div class="pricing-card-icon">🚐</div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label">Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'] * 2, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'] * 2, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label">Per Minute</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_minute_rate'] * 2, 2); ?></span>
                </div>
                <ul class="pricing-features">
                    <li>Up to 7 passengers</li>
                    <li>Spacious interiors</li>
                    <li>Extra luggage space</li>
                    <li>Child seats available</li>
                    <li>Ideal for airport transfers</li>
                </ul>
            </div>
            <div class="pricing-card-footer">
                <?php if(isLoggedIn()): ?>
                    <a href="dashboard.php" class="btn">Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="additional-info">
        <h3>Additional Charges</h3>
        <div class="additional-info-container">
            <div class="additional-item">
                <h4>Peak Hours</h4>
                <p>During high-demand hours (7-10 AM & 5-9 PM), a surcharge of 1.25× may apply to the total fare.</p>
            </div>
            
            <div class="additional-item">
                <h4>Waiting Time</h4>
                <p>First 5 minutes are free. After that, ₹2 per minute will be charged.</p>
            </div>
            
            <div class="additional-item">
                <h4>Cancellation</h4>
                <p>Free cancellation up to 2 minutes after booking. After that, a fee of ₹50 may apply.</p>
            </div>
            
            <div class="additional-item">
                <h4>Extra Stops</h4>
                <p>Each additional stop will incur a charge of ₹30.</p>
            </div>
        </div>
    </div>
    
    <div class="fare-calculator-promo">
        <h3>Calculate Your Fare</h3>
        <p>Want to know exactly how much your trip will cost? Use our fare calculator to get an estimate.</p>
        <a href="fare-calculator.php" class="btn">Try Our Fare Calculator</a>
    </div>
</div>

<style>
.pricing-container {
    margin-bottom: 40px;
}

.pricing-intro {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 30px;
}

.pricing-components {
    padding-left: 20px;
    margin: 15px 0;
}

.pricing-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.pricing-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.pricing-card:hover {
    transform: translateY(-5px);
}

.pricing-card.featured {
    border: 2px solid var(--primary-color);
    position: relative;
}

.featured-label {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: var(--primary-color);
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
}

.pricing-card-header {
    background-color: var(--dark-color);
    color: white;
    padding: 20px;
    text-align: center;
    position: relative;
}

.pricing-card-icon {
    font-size: 2.5rem;
    margin-top: 10px;
}

.pricing-card-body {
    padding: 20px;
}

.price-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.price-value {
    font-weight: bold;
}

.pricing-features {
    list-style-type: none;
    padding-left: 0;
    margin: 20px 0;
}

.pricing-features li {
    padding: 5px 0;
    position: relative;
    padding-left: 25px;
}

.pricing-features li:before {
    content: "✓";
    color: var(--success-color);
    position: absolute;
    left: 0;
}

.pricing-card-footer {
    padding: 20px;
    background-color: #f9f9f9;
    text-align: center;
}

.additional-info {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 30px;
}

.additional-info-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.additional-item {
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

.additional-item h4 {
    margin-bottom: 10px;
    color: var(--primary-color);
}

.fare-calculator-promo {
    background-color: var(--primary-color);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    text-align: center;
    color: white;
}

.fare-calculator-promo .btn {
    background-color: white;
    color: var(--primary-color);
    margin-top: 15px;
}

.fare-calculator-promo .btn:hover {
    background-color: var(--light-color);
}

@media (max-width: 768px) {
    .pricing-cards {
        grid-template-columns: 1fr;
    }
    
    .additional-info-container {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>