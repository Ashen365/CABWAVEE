<?php require_once 'includes/header.php'; ?>

<div class="page-header">
    <h2><i class="fas fa-concierge-bell"></i> Our Services</h2>
    <p>Discover our premium transportation solutions tailored to your needs</p>
</div>

<div class="services-container">
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-taxi"></i>
        </div>
        <h3>Standard Cab</h3>
        <p>Our standard cab service is perfect for everyday travel within the city. Comfortable, reliable, and affordable.</p>
        <ul class="service-features">
            <li><i class="fas fa-user"></i> Up to 4 passengers</li>
            <li><i class="fas fa-snowflake"></i> Air conditioning</li>
            <li><i class="fas fa-clock"></i> 24/7 availability</li>
            <li><i class="fas fa-map-marker-alt"></i> GPS tracking</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Starting from</span>
            <span class="price-amount">₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare']; 
            ?></span>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-car"></i>
        </div>
        <h3>Premium Sedan</h3>
        <p>Our premium sedan service offers a more luxurious travel experience with higher-end vehicles and added amenities.</p>
        <ul class="service-features">
            <li><i class="fas fa-user"></i> Up to 4 passengers</li>
            <li><i class="fas fa-gem"></i> Luxury vehicles</li>
            <li><i class="fas fa-wifi"></i> Free Wi-Fi</li>
            <li><i class="fas fa-tint"></i> Bottled water</li>
            <li><i class="fas fa-user-tie"></i> Professional drivers</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Starting from</span>
            <span class="price-amount">₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare'] * 1.5; 
            ?></span>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-shuttle-van"></i>
        </div>
        <h3>SUV/Minivan</h3>
        <p>Our SUV/Minivan service is ideal for larger groups or when you need extra space for luggage.</p>
        <ul class="service-features">
            <li><i class="fas fa-users"></i> Up to 7 passengers</li>
            <li><i class="fas fa-expand-alt"></i> Spacious interiors</li>
            <li><i class="fas fa-suitcase"></i> Extra luggage space</li>
            <li><i class="fas fa-baby"></i> Child seats available</li>
            <li><i class="fas fa-plane-departure"></i> Ideal for airport transfers</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Starting from</span>
            <span class="price-amount">₹<?php 
                $result = $conn->query("SELECT base_fare FROM pricing LIMIT 1");
                echo $result->fetch_assoc()['base_fare'] * 2; 
            ?></span>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-road"></i>
        </div>
        <h3>Outstation Trips</h3>
        <p>Planning a trip outside the city? Our outstation service offers comfortable vehicles for long-distance travel.</p>
        <ul class="service-features">
            <li><i class="fas fa-exchange-alt"></i> One-way or round trip</li>
            <li><i class="fas fa-car-alt"></i> Multiple vehicle options</li>
            <li><i class="fas fa-id-card"></i> Experienced highway drivers</li>
            <li><i class="fas fa-headset"></i> 24-hour support</li>
            <li><i class="fas fa-clock"></i> Flexible pickup and drop times</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Pricing</span>
            <span class="price-amount">Custom pricing based on distance</span>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h3>Scheduled Rides</h3>
        <p>Need a cab at a specific time? Our scheduled ride service lets you book in advance for peace of mind.</p>
        <ul class="service-features">
            <li><i class="fas fa-calendar-week"></i> Book up to 7 days in advance</li>
            <li><i class="fas fa-hourglass-start"></i> Guaranteed pickup time</li>
            <li><i class="fas fa-bell"></i> Reminder notifications</li>
            <li><i class="fas fa-car-side"></i> Choose your preferred vehicle</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Pricing</span>
            <span class="price-amount">Same as standard rates + ₹50 booking fee</span>
        </div>
        <?php if(isLoggedIn()): ?>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
        <?php else: ?>
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
        <?php endif; ?>
    </div>
    
    <div class="service-item">
        <div class="service-icon">
            <i class="fas fa-building"></i>
        </div>
        <h3>Corporate Accounts</h3>
        <p>We offer special packages for businesses with regular transportation needs for employees or clients.</p>
        <ul class="service-features">
            <li><i class="fas fa-user-tie"></i> Dedicated account manager</li>
            <li><i class="fas fa-file-invoice-dollar"></i> Monthly billing</li>
            <li><i class="fas fa-chart-line"></i> Customized reporting</li>
            <li><i class="fas fa-star"></i> Priority booking</li>
            <li><i class="fas fa-percentage"></i> Volume discounts</li>
        </ul>
        <div class="service-price">
            <span class="price-label">Pricing</span>
            <span class="price-amount">Contact us for custom quotes</span>
        </div>
        <a href="contact.php" class="btn btn-primary"><i class="fas fa-envelope"></i> Contact Us</a>
    </div>
</div>

<div class="pricing-info">
    <h3><i class="fas fa-tags"></i> Pricing Information</h3>
    <p>Our pricing is transparent with no hidden charges.</p>
    
    <?php
    // Get pricing information
    $result = $conn->query("SELECT * FROM pricing LIMIT 1");
    $pricing = $result->fetch_assoc();
    ?>
    
    <div class="pricing-details">
        <div class="pricing-item">
            <div class="pricing-icon"><i class="fas fa-flag-checkered"></i></div>
            <h4>Base Fare</h4>
            <p class="pricing-value">₹<?php echo $pricing['base_fare']; ?></p>
        </div>
        
        <div class="pricing-item">
            <div class="pricing-icon"><i class="fas fa-route"></i></div>
            <h4>Per Kilometer Rate</h4>
            <p class="pricing-value">₹<?php echo $pricing['per_km_rate']; ?><span class="pricing-unit">per km</span></p>
        </div>
        
        <div class="pricing-item">
            <div class="pricing-icon"><i class="fas fa-stopwatch"></i></div>
            <h4>Per Minute Rate</h4>
            <p class="pricing-value">₹<?php echo $pricing['per_minute_rate']; ?><span class="pricing-unit">per minute</span></p>
        </div>
    </div>
    
    <p class="pricing-note"><i class="fas fa-info-circle"></i> Additional charges may apply during peak hours, holidays, or for special services.</p>
    <div class="pricing-button">
        <a href="pricing.php" class="btn"><i class="fas fa-list-ul"></i> View Full Pricing Details</a>
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
}

.page-header h2 i {
    color: var(--primary-color);
    margin-right: 10px;
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

/* Services Container */
.services-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

/* Service Item */
.service-item {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    padding: 30px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.service-item:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-md);
}

.service-item::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.service-item:hover::before {
    opacity: 1;
}

/* Service Icon */
.service-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(255, 107, 107, 0.1));
    border-radius: 50%;
    font-size: 2rem;
    color: var(--primary-color);
}

/* Service Title and Description */
.service-item h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--dark-color);
}

.service-item > p {
    color: var(--gray-color);
    margin-bottom: 20px;
    line-height: 1.6;
}

/* Service Features */
.service-features {
    list-style-type: none;
    padding-left: 0;
    margin: 20px 0;
}

.service-features li {
    padding: 8px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    color: var(--text-color);
}

.service-features li:last-child {
    border-bottom: none;
}

.service-features li i {
    margin-right: 10px;
    color: var(--primary-color);
    width: 20px;
    text-align: center;
}

/* Service Price */
.service-price {
    margin: 20px 0;
    padding: 15px;
    background-color: rgba(67, 97, 238, 0.05);
    border-radius: 8px;
    text-align: center;
}

.price-label {
    display: block;
    font-size: 0.9rem;
    color: var(--gray-color);
    margin-bottom: 5px;
}

.price-amount {
    display: block;
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--primary-color);
}

/* Buttons */
.service-item .btn {
    margin-top: auto;
    align-self: center;
    padding: 10px 20px;
    width: 100%;
}

.btn-primary {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    border: none;
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    transform: translateY(-2px);
}

/* Pricing Info Section */
.pricing-info {
    background: linear-gradient(135deg, #f7f9fc, #edf1f7);
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    margin-bottom: 50px;
    box-shadow: var(--shadow-sm);
}

.pricing-info h3 {
    color: var(--dark-color);
    font-size: 1.8rem;
    margin-bottom: 15px;
    display: inline-flex;
    align-items: center;
}

.pricing-info h3 i {
    margin-right: 10px;
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
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
    margin: 30px 0;
}

.pricing-item {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
    background-color: white;
    border-radius: 12px;
    padding: 25px 20px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.pricing-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.pricing-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(255, 107, 107, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.5rem;
    color: var(--primary-color);
}

.pricing-item h4 {
    color: var(--dark-color);
    font-size: 1.2rem;
    margin-bottom: 15px;
    font-weight: 600;
}

.pricing-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0;
    display: flex;
    align-items: baseline;
    justify-content: center;
}

.pricing-unit {
    font-size: 0.9rem;
    font-weight: 400;
    color: var(--gray-color);
    margin-left: 5px;
}

/* Pricing Note */
.pricing-note {
    font-style: italic;
    color: var(--gray-color);
    margin: 30px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pricing-note i {
    margin-right: 8px;
    color: var(--primary-color);
}

.pricing-button {
    margin-top: 20px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .page-header h2 {
        font-size: 1.8rem;
    }
    
    .services-container {
        grid-template-columns: 1fr;
    }
    
    .service-item {
        padding: 25px 20px;
    }
    
    .service-icon {
        width: 70px;
        height: 70px;
        font-size: 1.7rem;
    }
    
    .pricing-info {
        padding: 30px 20px;
    }
    
    .pricing-details {
        flex-direction: column;
        align-items: center;
    }
    
    .pricing-item {
        width: 100%;
        max-width: 100%;
    }
}

/* Animation classes */
.fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.slide-up {
    animation: slideUp 0.8s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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
        
        // Service items animation
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            
            gsap.from('.service-item', {
                scrollTrigger: {
                    trigger: '.services-container',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.2,
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
        } else {
            // Fallback animations without ScrollTrigger
            gsap.from('.service-item', {
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.2,
                delay: 0.5,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-info', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 1.5,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-item', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.2,
                delay: 1.8,
                ease: 'power2.out'
            });
        }
    } else {
        // Fallback CSS animations
        document.querySelectorAll('.page-header h2, .page-header p').forEach(el => {
            el.classList.add('fade-in');
        });
        
        document.querySelectorAll('.service-item').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
        
        document.querySelector('.pricing-info').classList.add('slide-up');
        
        document.querySelectorAll('.pricing-item').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>