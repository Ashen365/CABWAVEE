<?php require_once 'includes/header.php'; ?>

<div class="page-header">
    <h2>Our Services</h2>
    <p>Discover the range of cab services we offer</p>
</div>

<div class="services-container">
    <div class="service-item">
        <div class="service-icon">🚕</div>
        <h3>Standard Cab</h3>
        <p>Our standard cab service is perfect for everyday travel within the city. Comfortable, reliable, and affordable.</p>
        <ul class="service-features">
            <li>Up to 4 passengers</li>
            <li>Air conditioning</li>
            <li>24/7 availability</li>
            <li>GPS tracking</li>
        </ul>
        <div class="service-price">
            <p>Starting from ₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare']; 
            ?></p>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">🚗</div>
        <h3>Premium Sedan</h3>
        <p>Our premium sedan service offers a more luxurious travel experience with higher-end vehicles and added amenities.</p>
        <ul class="service-features">
            <li>Up to 4 passengers</li>
            <li>Luxury vehicles</li>
            <li>Free Wi-Fi</li>
            <li>Bottled water</li>
            <li>Professional drivers</li>
        </ul>
        <div class="service-price">
            <p>Starting from ₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare'] * 1.5; 
            ?></p>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">🚐</div>
        <h3>SUV/Minivan</h3>
        <p>Our SUV/Minivan service is ideal for larger groups or when you need extra space for luggage.</p>
        <ul class="service-features">
            <li>Up to 7 passengers</li>
            <li>Spacious interiors</li>
            <li>Extra luggage space</li>
            <li>Child seats available</li>
            <li>Ideal for airport transfers</li>
        </ul>
        <div class="service-price">
            <p>Starting from ₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare'] * 2; 
            ?></p>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">🛣️</div>
        <h3>Outstation Trips</h3>
        <p>Planning a trip outside the city? Our outstation service offers comfortable vehicles for long-distance travel.</p>
        <ul class="service-features">
            <li>One-way or round trip</li>
            <li>Multiple vehicle options</li>
            <li>Experienced highway drivers</li>
            <li>24-hour support</li>
            <li>Flexible pickup and drop times</li>
        </ul>
        <div class="service-price">
            <p>Custom pricing based on distance</p>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">📅</div>
        <h3>Scheduled Rides</h3>
        <p>Need a cab at a specific time? Our scheduled ride service lets you book in advance for peace of mind.</p>
        <ul class="service-features">
            <li>Book up to 7 days in advance</li>
            <li>Guaranteed pickup time</li>
            <li>Reminder notifications</li>
            <li>Choose your preferred vehicle</li>
        </ul>
        <div class="service-price">
            <p>Same as standard rates + ₹50 booking fee</p>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn">Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">🏢</div>
        <h3>Corporate Accounts</h3>
        <p>We offer special packages for businesses with regular transportation needs for employees or clients.</p>
        <ul class="service-features">
            <li>Dedicated account manager</li>
            <li>Monthly billing</li>
            <li>Customized reporting</li>
            <li>Priority booking</li>
            <li>Volume discounts</li>
        </ul>
        <div class="service-price">
            <p>Contact us for custom quotes</p>
        </div>
        <a href="contact.php" class="btn">Contact Us</a>
    </div>
</div>

<div class="pricing-info">
    <h3>Pricing Information</h3>
    <p>Our pricing is transparent with no hidden charges.</p>
    
    <?php
    // Get pricing information
    $result = $conn->query("SELECT * FROM pricing LIMIT 1");
    $pricing = $result->fetch_assoc();
    ?>
    
    <div class="pricing-details">
        <div class="pricing-item">
            <h4>Base Fare</h4>
            <p>₹<?php echo $pricing['base_fare']; ?></p>
        </div>
        
        <div class="pricing-item">
            <h4>Per Kilometer Rate</h4>
            <p>₹<?php echo $pricing['per_km_rate']; ?> per km</p>
        </div>
        
        <div class="pricing-item">
            <h4>Per Minute Rate</h4>
            <p>₹<?php echo $pricing['per_minute_rate']; ?> per minute</p>
        </div>
    </div>
    
    <p class="pricing-note">Additional charges may apply during peak hours, holidays, or for special services.</p>
    <p><a href="pricing.php" class="btn">View Full Pricing Details</a></p>
</div>

<style>
.page-header {
    text-align: center;
    margin-bottom: 30px;
}

.services-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.service-item {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
    transition: transform 0.3s ease;
}

.service-item:hover {
    transform: translateY(-5px);
}

.service-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    color: var(--primary-color);
}

.service-features {
    list-style-type: none;
    padding-left: 0;
    margin: 15px 0;
}

.service-features li {
    padding: 5px 0;
    border-bottom: 1px solid #f0f0f0;
}

.service-features li:last-child {
    border-bottom: none;
}

.service-price {
    font-weight: bold;
    margin: 15px 0;
    color: var(--dark-color);
}

.pricing-info {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
    text-align: center;
    margin-bottom: 30px;
}

.pricing-details {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin: 20px 0;
}

.pricing-item {
    flex: 1;
    min-width: 200px;
    margin: 10px;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 5px;
}

.pricing-note {
    font-style: italic;
    color: #666;
    margin-bottom: 20px;
}
</style>

<?php require_once 'includes/footer.php'; ?>