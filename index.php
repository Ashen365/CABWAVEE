<?php require_once 'includes/header.php'; ?>

<div class="hero">
    <h1>Welcome to <?php echo SITE_NAME; ?></h1>
    <p>Your reliable transportation solution</p>
    <?php if(!isLoggedIn()): ?>
        <div class="hero-buttons">
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        </div>
    <?php else: ?>
        <a href="dashboard.php" class="btn">Book a Cab</a>
    <?php endif; ?>
</div>

<div class="features">
    <div class="feature">
        <div class="feature-icon">🚕</div>
        <h3>Quick Booking</h3>
        <p>Book a cab in just a few clicks and get picked up within minutes.</p>
    </div>
    
    <div class="feature">
        <div class="feature-icon">👨‍✈️</div>
        <h3>Professional Drivers</h3>
        <p>All our drivers are professionally trained and vetted for your safety.</p>
    </div>
    
    <div class="feature">
        <div class="feature-icon">💰</div>
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

<style>
.hero {
    text-align: center;
    padding: 50px 20px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 8px;
    margin-bottom: 30px;
}

.hero h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

.hero-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.hero-buttons .btn {
    background-color: white;
    color: var(--primary-color);
}

.hero-buttons .btn:hover {
    background-color: var(--light-color);
}

.features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.feature {
    text-align: center;
    padding: 30px 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.feature:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.how-it-works {
    text-align: center;
    margin-bottom: 50px;
}

.how-it-works h2 {
    margin-bottom: 30px;
}

.steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));