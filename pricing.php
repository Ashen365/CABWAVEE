<?php
require_once 'includes/header.php';

// Get pricing information from database
$pricing_query = $conn->query("SELECT * FROM pricing LIMIT 1");
$pricing = $pricing_query->fetch_assoc();
?>

<div class="page-header">
    <h2><i class="fas fa-tags"></i> Our Pricing</h2>
    <p>Transparent pricing with no hidden charges</p>
</div>

<div class="pricing-container">
    <div class="pricing-intro card">
        <h3><i class="fas fa-info-circle"></i> How Our Pricing Works</h3>
        <p>At CABWAVE, we believe in complete transparency. Our fare is calculated based on three main components:</p>
        <ul class="pricing-components">
            <li><i class="fas fa-flag-checkered"></i> <strong>Base Fare:</strong> A flat fee that covers the initial pickup</li>
            <li><i class="fas fa-route"></i> <strong>Distance Charge:</strong> A per-kilometer rate for the distance traveled</li>
            <li><i class="fas fa-clock"></i> <strong>Time Charge:</strong> A per-minute rate for the duration of your trip</li>
        </ul>
        <div class="formula-box">
            <div class="formula-title">Fare Formula</div>
            <div class="formula">Total Fare = Base Fare + (Distance × Per KM Rate) + (Time × Per Minute Rate)</div>
        </div>
    </div>
    
    <div class="pricing-cards">
        <div class="pricing-card">
            <div class="pricing-card-header">
                <h3>Standard</h3>
                <div class="pricing-card-icon">
                    <i class="fas fa-taxi"></i>
                </div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-flag-checkered"></i> Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'], 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-road"></i> Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'], 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-hourglass-half"></i> Per Minute</span>
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
                    <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="pricing-card featured">
            <div class="pricing-card-header">
                <h3>Premium</h3>
                <div class="pricing-card-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="featured-label"><i class="fas fa-star"></i> Most Popular</div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-flag-checkered"></i> Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'] * 1.5, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-road"></i> Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'] * 1.5, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-hourglass-half"></i> Per Minute</span>
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
                    <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="pricing-card">
            <div class="pricing-card-header">
                <h3>SUV/Minivan</h3>
                <div class="pricing-card-icon">
                    <i class="fas fa-shuttle-van"></i>
                </div>
            </div>
            <div class="pricing-card-body">
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-flag-checkered"></i> Base Fare</span>
                    <span class="price-value">₹<?php echo number_format($pricing['base_fare'] * 2, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-road"></i> Per Kilometer</span>
                    <span class="price-value">₹<?php echo number_format($pricing['per_km_rate'] * 2, 2); ?></span>
                </div>
                <div class="price-item">
                    <span class="price-label"><i class="fas fa-hourglass-half"></i> Per Minute</span>
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
                    <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-car"></i> Book Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Book</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="additional-info">
        <h3><i class="fas fa-info-circle"></i> Additional Charges</h3>
        <div class="additional-info-container">
            <div class="additional-item">
                <div class="additional-icon"><i class="fas fa-chart-line"></i></div>
                <h4>Peak Hours</h4>
                <p>During high-demand hours (7-10 AM & 5-9 PM), a surcharge of 1.25× may apply to the total fare.</p>
            </div>
            
            <div class="additional-item">
                <div class="additional-icon"><i class="fas fa-stopwatch"></i></div>
                <h4>Waiting Time</h4>
                <p>First 5 minutes are free. After that, ₹2 per minute will be charged.</p>
            </div>
            
            <div class="additional-item">
                <div class="additional-icon"><i class="fas fa-ban"></i></div>
                <h4>Cancellation</h4>
                <p>Free cancellation up to 2 minutes after booking. After that, a fee of ₹50 may apply.</p>
            </div>
            
            <div class="additional-item">
                <div class="additional-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h4>Extra Stops</h4>
                <p>Each additional stop will incur a charge of ₹30.</p>
            </div>
        </div>
    </div>
    
    <div class="fare-calculator-promo">
        <div class="promo-content">
            <h3>Calculate Your Fare</h3>
            <p>Want to know exactly how much your trip will cost? Use our fare calculator to get an estimate.</p>
            <a href="fare-calculator.php" class="btn btn-light"><i class="fas fa-calculator"></i> Try Our Fare Calculator</a>
        </div>
        <div class="promo-image">
            <i class="fas fa-calculator calc-icon"></i>
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

/* Pricing Container */
.pricing-container {
    margin-bottom: 60px;
}

/* Card Styling */
.card {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

/* Pricing Intro */
.pricing-intro {
    padding: 30px;
    margin-bottom: 40px;
}

.pricing-intro h3 {
    color: var(--dark-color);
    font-size: 1.5rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.pricing-intro h3 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.pricing-intro p {
    color: var(--text-color);
    margin-bottom: 20px;
    line-height: 1.6;
}

.pricing-components {
    list-style-type: none;
    padding-left: 0;
    margin: 20px 0 25px;
}

.pricing-components li {
    padding: 8px 0;
    color: var(--text-color);
    display: flex;
    align-items: center;
}

.pricing-components li i {
    margin-right: 10px;
    color: var(--primary-color);
    width: 20px;
    text-align: center;
}

.formula-box {
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.05), rgba(255, 107, 107, 0.05));
    border-radius: 12px;
    padding: 20px;
    margin-top: 25px;
    border-left: 4px solid var(--primary-color);
}

.formula-title {
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.formula {
    font-family: 'Courier New', monospace;
    background-color: rgba(255, 255, 255, 0.7);
    padding: 10px 15px;
    border-radius: 8px;
    overflow-x: auto;
    white-space: nowrap;
}

/* Pricing Cards */
.pricing-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.pricing-card {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.pricing-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-md);
}

.pricing-card.featured {
    border: 2px solid var(--primary-color);
    position: relative;
    transform: scale(1.03);
    box-shadow: var(--shadow-md);
}

.pricing-card.featured:hover {
    transform: scale(1.03) translateY(-10px);
    box-shadow: var(--shadow-lg);
}

.featured-label {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.featured-label i {
    margin-right: 5px;
}

.pricing-card-header {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    padding: 25px 20px;
    text-align: center;
    position: relative;
}

.pricing-card.featured .pricing-card-header {
    background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
}

.pricing-card-header h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    font-weight: 600;
}

.pricing-card-icon {
    width: 70px;
    height: 70px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.pricing-card-body {
    padding: 25px;
    flex-grow: 1;
}

.price-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.price-label {
    color: var(--text-color);
    display: flex;
    align-items: center;
}

.price-label i {
    margin-right: 8px;
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.price-value {
    font-weight: 600;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.pricing-features {
    list-style-type: none;
    padding-left: 0;
    margin: 25px 0 10px;
}

.pricing-features li {
    padding: 8px 0;
    position: relative;
    padding-left: 30px;
    color: var(--text-color);
}

.pricing-features li:before {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: var(--success-color);
    position: absolute;
    left: 0;
}

.pricing-card-footer {
    padding: 20px;
    background-color: rgba(247, 249, 252, 0.8);
    text-align: center;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.pricing-card-footer .btn {
    width: 100%;
    padding: 12px;
}

/* Additional Info Section */
.additional-info {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    padding: 30px;
    margin-bottom: 50px;
}

.additional-info h3 {
    color: var(--dark-color);
    font-size: 1.6rem;
    margin-bottom: 25px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.additional-info h3 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.additional-info-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.additional-item {
    background-color: rgba(247, 249, 252, 0.8);
    border-radius: 12px;
    padding: 25px 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    box-shadow: var(--shadow-sm);
}

.additional-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.additional-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), #5a74f1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 15px;
    color: white;
}

.additional-item h4 {
    margin-bottom: 15px;
    color: var(--dark-color);
    font-size: 1.2rem;
}

.additional-item p {
    color: var(--text-color);
    line-height: 1.6;
}

/* Fare Calculator Promo */
.fare-calculator-promo {
    background: linear-gradient(135deg, var(--primary-color), #5a74f1);
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    margin-bottom: 30px;
    color: white;
    display: flex;
    overflow: hidden;
}

.promo-content {
    padding: 40px;
    flex: 1;
}

.fare-calculator-promo h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    font-weight: 600;
}

.fare-calculator-promo p {
    margin-bottom: 25px;
    opacity: 0.9;
    font-size: 1.1rem;
    line-height: 1.6;
}

.btn-light {
    background-color: white;
    color: var(--primary-color);
    padding: 12px 25px;
    font-weight: 500;
}

.btn-light:hover {
    background-color: var(--light-color);
    transform: translateY(-2px);
}

.promo-image {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    background-color: rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.calc-icon {
    font-size: 8rem;
    color: rgba(255, 255, 255, 0.2);
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .pricing-cards {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
    
    .fare-calculator-promo {
        flex-direction: column;
    }
    
    .promo-image {
        padding: 20px;
    }
    
    .calc-icon {
        font-size: 5rem;
    }
}

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 1.8rem;
    }
    
    .pricing-intro, 
    .additional-info, 
    .promo-content {
        padding: 25px 20px;
    }
    
    .pricing-card {
        max-width: 100%;
    }
    
    .formula {
        font-size: 0.9rem;
    }
    
    .additional-info-container {
        grid-template-columns: 1fr;
    }
}

/* Animation classes */
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

/* Featured card pulse animation */
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(67, 97, 238, 0); }
    100% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0); }
}

.pricing-card.featured {
    animation: pulse 2s infinite;
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
        
        // Register ScrollTrigger if available
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            
            gsap.from('.pricing-intro', {
                scrollTrigger: {
                    trigger: '.pricing-intro',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-card', {
                scrollTrigger: {
                    trigger: '.pricing-cards',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.2,
                ease: 'power2.out'
            });
            
            gsap.from('.additional-item', {
                scrollTrigger: {
                    trigger: '.additional-info',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.15,
                ease: 'power2.out'
            });
            
            gsap.from('.fare-calculator-promo', {
                scrollTrigger: {
                    trigger: '.fare-calculator-promo',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
        } else {
            // Fallback animations without ScrollTrigger
            gsap.from('.pricing-intro', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 0.5,
                ease: 'power2.out'
            });
            
            gsap.from('.pricing-card', {
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.2,
                delay: 0.8,
                ease: 'power2.out'
            });
            
            gsap.from('.additional-item', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.15,
                delay: 1.5,
                ease: 'power2.out'
            });
            
            gsap.from('.fare-calculator-promo', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                delay: 2,
                ease: 'power2.out'
            });
        }
    } else {
        // Fallback CSS animations
        document.querySelectorAll('.page-header h2, .page-header p').forEach(el => {
            el.classList.add('fade-in');
        });
        
        document.querySelector('.pricing-intro').classList.add('slide-up');
        
        document.querySelectorAll('.pricing-card').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
        
        document.querySelectorAll('.additional-item').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
        
        document.querySelector('.fare-calculator-promo').classList.add('slide-up');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>