<?php require_once 'includes/header.php';?>

<div class="hero">
    <h1>Welcome to <?php echo SITE_NAME; ?></h1>
    <p>Your reliable transportation solution</p>
    <?php if(!isLoggedIn()): ?>
        <div class="hero-buttons">
            <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register.php" class="btn"><i class="fas fa-user-plus"></i> Register</a>
        </div>
    <?php else: ?>
        <a href="dashboard.php" class="btn"><i class="fas fa-taxi"></i> Book a Cab</a>
    <?php endif; ?>
</div>

<div class="features">
    <div class="feature">
        <div class="feature-icon"><i class="fas fa-bolt"></i></div>
        <h3>Quick Booking</h3>
        <p>Book a cab in just a few clicks and get picked up within minutes.</p>
    </div>
    
    <div class="feature">
        <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
        <h3>Professional Drivers</h3>
        <p>All our drivers are professionally trained and vetted for your safety.</p>
    </div>
    
    <div class="feature">
        <div class="feature-icon"><i class="fas fa-tag"></i></div>
        <h3>Affordable Prices</h3>
        <p>Enjoy competitive rates and transparent pricing with no hidden fees.</p>
    </div>
</div>

<div class="how-it-works">
    <h2>How It Works</h2>
    
    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <h3>Register/Login</h3>
            <p>Create an account or login to your existing account.</p>
        </div>
        
        <div class="step">
            <div class="step-number">2</div>
            <h3>Book a Cab</h3>
            <p>Enter your pickup and dropoff locations to book a cab.</p>
        </div>
        
        <div class="step">
            <div class="step-number">3</div>
            <h3>Get Picked Up</h3>
            <p>A driver will be assigned to you and will pick you up at your location.</p>
        </div>
        
        <div class="step">
            <div class="step-number">4</div>
            <h3>Enjoy Your Ride</h3>
            <p>Sit back, relax, and enjoy your comfortable ride to your destination.</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php';?>