<?php require_once 'includes/header.php';?>

<!-- Enhanced Hero Section with 3D Animation -->
<div class="hero modern-hero">
    <div class="hero-content">
        <h1 class="animate-fade-up">Welcome to <span class="highlight"><?php echo SITE_NAME; ?></span></h1>
        <p class="animate-fade-up animation-delay-1">Your premium transportation solution</p>
        
        <div class="hero-buttons animate-fade-up animation-delay-2">
            <?php if(!isLoggedIn()): ?>
                <a href="login.php" class="btn btn-primary pulse-effect"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="register.php" class="btn btn-secondary"><i class="fas fa-user-plus"></i> Register</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn btn-primary pulse-effect"><i class="fas fa-taxi"></i> Book a Cab</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-image animate-fade-in">
        <!-- New modern luxury car image -->
        <img src="assets/images/luxury-car.png" alt="Premium Taxi Service" class="floating">
    </div>
    
    <!-- Floating elements for visual enhancement -->
    <div class="floating-element circle1"></div>
    <div class="floating-element circle2"></div>
    <div class="floating-element square1"></div>
</div>

<!-- Enhanced Wave Separator -->
<div class="wave-separator">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,133.3C672,128,768,160,864,165.3C960,171,1056,149,1152,149.3C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

<!-- Enhanced Features Section with Animation -->
<div class="features animate-section">
    <h2 class="section-title">Why Choose Us</h2>
    
    <div class="features-container">
        <div class="feature animate-from-left">
            <div class="feature-icon"><i class="fas fa-bolt"></i></div>
            <h3>Quick Booking</h3>
            <p>Book a premium cab in just a few taps and get picked up within minutes.</p>
            <div class="feature-bg"></div>
        </div>
        
        <div class="feature animate-from-bottom animation-delay-1">
            <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
            <h3>Professional Drivers</h3>
            <p>All our drivers are professionally trained and vetted for your comfort and safety.</p>
            <div class="feature-bg"></div>
        </div>
        
        <div class="feature animate-from-right animation-delay-2">
            <div class="feature-icon"><i class="fas fa-tag"></i></div>
            <h3>Affordable Luxury</h3>
            <p>Enjoy competitive rates for premium service with transparent pricing and no hidden fees.</p>
            <div class="feature-bg"></div>
        </div>
    </div>
</div>

<!-- Enhanced Statistics Section with 3D Elements -->
<div class="stats-section animate-section">
    <div class="stat animate-count">
        <div class="stat-number" data-count="5000">0</div>
        <div class="stat-label">Happy Customers</div>
        <div class="stat-icon"><i class="fas fa-smile"></i></div>
    </div>
    <div class="stat animate-count animation-delay-1">
        <div class="stat-number" data-count="500">0</div>
        <div class="stat-label">Professional Drivers</div>
        <div class="stat-icon"><i class="fas fa-id-card"></i></div>
    </div>
    <div class="stat animate-count animation-delay-2">
        <div class="stat-number" data-count="1000">0</div>
        <div class="stat-label">Rides Per Day</div>
        <div class="stat-icon"><i class="fas fa-route"></i></div>
    </div>
    <div class="stat animate-count animation-delay-3">
        <div class="stat-number" data-count="25">0</div>
        <div class="stat-label">Cities Covered</div>
        <div class="stat-icon"><i class="fas fa-city"></i></div>
    </div>
</div>

<!-- Fixed How It Works Section -->
<div class="how-it-works animate-section">
    <h2 class="section-title">How It Works</h2>
    
    <div class="steps-container">
        <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-icon">
                <img src="assets/images/register-icon.svg" alt="Register">
            </div>
            <h3>Register/Login</h3>
            <p>Create an account or login to access our premium cab services with exclusive benefits.</p>
        </div>
        
        <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-icon">
                <img src="assets/images/booking-icon.svg" alt="Book">
            </div>
            <h3>Book a Cab</h3>
            <p>Enter your pickup and dropoff locations to book your premium ride instantly.</p>
        </div>
        
        <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-icon">
                <img src="assets/images/pickup-icon.svg" alt="Pickup">
            </div>
            <h3>Get Picked Up</h3>
            <p>A professional driver will be assigned and will arrive at your location promptly.</p>
        </div>
        
        <div class="step-item">
            <div class="step-number">4</div>
            <div class="step-icon">
                <img src="assets/images/ride-icon.svg" alt="Ride">
            </div>
            <h3>Enjoy Your Ride</h3>
            <p>Sit back, relax, and enjoy your comfortable ride to your destination in style.</p>
        </div>
    </div>
</div>

<!-- Enhanced Call to Action Section with Parallax Effect -->
<div class="cta-section animate-section" data-parallax="scroll" data-image-src="assets/images/cta-bg.jpg">
    <div class="cta-overlay"></div>
    <div class="cta-content">
        <h2>Ready to Experience Premium Cab Service?</h2>
        <p>Join thousands of satisfied customers who trust <?php echo SITE_NAME; ?> for their transportation needs.</p>
        <a href="<?php echo isLoggedIn() ? 'dashboard.php' : 'register.php'; ?>" class="btn btn-large btn-glow">
            <i class="fas fa-<?php echo isLoggedIn() ? 'car' : 'user-plus'; ?>"></i> <?php echo isLoggedIn() ? 'Book Now' : 'Get Started'; ?>
        </a>
    </div>
</div>

<!-- Mobile App Download Section -->
<div class="app-download animate-section">
    <div class="app-content">
        <h2>Download Our Mobile App</h2>
        <p>Get exclusive deals and book cabs on the go with our mobile application</p>
        <div class="app-buttons">
            <a href="#" class="app-btn">
                <i class="fab fa-apple"></i>
                <span>
                    <small>Download on the</small>
                    App Store
                </span>
            </a>
            <a href="#" class="app-btn">
                <i class="fab fa-google-play"></i>
                <span>
                    <small>Get it on</small>
                    Google Play
                </span>
            </a>
        </div>
    </div>
    <div class="app-image">
        <img src="assets/images/mobile-app.png" alt="Mobile App" class="floating-slow">
    </div>
</div>

<!-- Enhanced Animation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize GSAP ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);
    
    // Fade Up Animations with improved timing
    gsap.utils.toArray('.animate-fade-up').forEach((element, index) => {
        gsap.from(element, {
            y: 50,
            opacity: 0,
            duration: 1.2,
            delay: index * 0.2,
            ease: "power3.out"
        });
    });
    
    // Enhanced Fade In Animation
    gsap.utils.toArray('.animate-fade-in').forEach(element => {
        gsap.from(element, {
            opacity: 0,
            scale: 0.95,
            duration: 1.8,
            ease: "power2.out"
        });
    });
    
    // Section Animations with better scroll triggers
    gsap.utils.toArray('.animate-section').forEach(section => {
        gsap.from(section, {
            opacity: 0,
            y: 30,
            duration: 1.2,
            scrollTrigger: {
                trigger: section,
                start: "top 85%",
                toggleActions: "play none none none"
            }
        });
    });
    
    // Enhanced Feature Animations
    gsap.from('.animate-from-left', {
        x: -100,
        opacity: 0,
        duration: 1.2,
        scrollTrigger: {
            trigger: '.animate-from-left',
            start: "top 80%"
        }
    });
    
    gsap.from('.animate-from-right', {
        x: 100,
        opacity: 0,
        duration: 1.2,
        scrollTrigger: {
            trigger: '.animate-from-right',
            start: "top 80%"
        }
    });
    
    gsap.from('.animate-from-bottom', {
        y: 100,
        opacity: 0,
        duration: 1.2,
        scrollTrigger: {
            trigger: '.animate-from-bottom',
            start: "top 80%"
        }
    });
    
    // Animate step items
    gsap.utils.toArray('.step-item').forEach((item, index) => {
        gsap.from(item, {
            y: 50,
            opacity: 0,
            delay: index * 0.2,
            duration: 1,
            scrollTrigger: {
                trigger: item,
                start: "top 80%"
            }
        });
    });
    
    // Add hover animation for step items
    document.querySelectorAll('.step-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            gsap.to(this.querySelector('img'), {
                rotation: 10,
                scale: 1.1,
                duration: 0.3
            });
        });
        
        item.addEventListener('mouseleave', function() {
            gsap.to(this.querySelector('img'), {
                rotation: 0,
                scale: 1,
                duration: 0.3
            });
        });
    });
    
    // Improved Number Counter Animation
    gsap.utils.toArray('.animate-count').forEach(stat => {
        const countElement = stat.querySelector('.stat-number');
        const finalValue = parseInt(countElement.dataset.count);
        
        ScrollTrigger.create({
            trigger: stat,
            start: "top 85%",
            onEnter: () => {
                gsap.to(countElement, {
                    duration: 2.5,
                    innerText: finalValue,
                    snap: { innerText: 1 },
                    ease: "power2.out"
                });
                
                // Add icon animation when counter starts
                gsap.from(stat.querySelector('.stat-icon'), {
                    scale: 0.2,
                    rotation: 360,
                    opacity: 0,
                    duration: 1.2,
                    ease: "back.out(1.7)"
                });
            }
        });
    });
    
    // Add parallax effect to CTA section if parallax.js is available
    if (typeof parallax !== 'undefined') {
        var parallaxInstance = new parallax('.cta-section');
    }
    
    // Add floating animation to the hero image
    gsap.to('.floating', {
        y: 15,
        duration: 2,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });
    
    // Add slower floating animation to app image
    gsap.to('.floating-slow', {
        y: 10,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });
    
    // Add animation to floating elements
    gsap.to('.floating-element', {
        x: "random(-20, 20)",
        y: "random(-20, 20)",
        rotation: "random(-15, 15)",
        duration: "random(3, 6)",
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
        stagger: 0.5
    });
    
    // Add hover effects to features
    document.querySelectorAll('.feature').forEach(feature => {
        feature.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -10,
                boxShadow: "0 20px 50px rgba(0,0,0,0.15)",
                duration: 0.3
            });
            gsap.to(this.querySelector('.feature-icon'), {
                scale: 1.2,
                color: "var(--primary-color)",
                duration: 0.3
            });
        });
        
        feature.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                boxShadow: "0 10px 30px rgba(0,0,0,0.05)",
                duration: 0.3
            });
            gsap.to(this.querySelector('.feature-icon'), {
                scale: 1,
                color: "currentColor",
                duration: 0.3
            });
        });
    });
});
</script>

<?php require_once 'includes/footer.php';?>