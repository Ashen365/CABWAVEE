<?php
require_once 'includes/header.php';

$error = '';
$success = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        // Query the database
        $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (md5($password) === $user['password']) { // Note: MD5 is not secure, consider using password_hash/verify in production
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    redirect('admin/index.php');
                } else {
                    redirect('dashboard.php');
                }
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
        
        $stmt->close();
    }
}
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><i class="fas fa-sign-in-alt"></i> Login to Your Account</h2>
            <p>Welcome back! Please enter your credentials to continue</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="auth-form">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
        </div>
    </div>
    
    <div class="auth-features">
        <div class="auth-feature">
            <div class="feature-icon">
                <i class="fas fa-route"></i>
            </div>
            <h3>Book Rides Easily</h3>
            <p>Login to book rides, save your favorite destinations, and track your journey in real-time.</p>
        </div>
        
        <div class="auth-feature">
            <div class="feature-icon">
                <i class="fas fa-history"></i>
            </div>
            <h3>Access Your History</h3>
            <p>View all your past rides, receipts and easily book return trips.</p>
        </div>
        
        <div class="auth-feature">
            <div class="feature-icon">
                <i class="fas fa-tag"></i>
            </div>
            <h3>Exclusive Offers</h3>
            <p>Get access to special discounts and promotions available only for registered users.</p>
        </div>
    </div>
</div>

<style>
/* Auth Container */
.auth-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    max-width: 1200px;
    margin: 50px auto 80px;
    padding: 0 20px;
}

/* Auth Card */
.auth-card {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.auth-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.auth-header {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    padding: 30px;
    color: white;
    text-align: center;
}

.auth-header h2 {
    font-size: 1.8rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.auth-header h2 i {
    margin-right: 10px;
}

.auth-header p {
    opacity: 0.9;
    font-size: 0.95rem;
}

/* Alert Boxes */
.alert {
    margin: 20px 30px 0;
    padding: 12px 15px;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.alert i {
    margin-right: 10px;
    font-size: 1.1rem;
}

.alert-danger {
    background-color: #FFE5E8;
    color: #842029;
    border-left: 4px solid var(--danger-color);
}

.alert-success {
    background-color: #D1E7DD;
    color: #0F5132;
    border-left: 4px solid var(--success-color);
}

/* Auth Form */
.auth-form {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--dark-color);
}

.form-group label i {
    margin-right: 8px;
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    outline: none;
}

input::placeholder {
    color: #a0aec0;
}

/* Password Field with Toggle */
.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #a0aec0;
    cursor: pointer;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: var(--primary-color);
}

/* Form Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.remember-me {
    display: flex;
    align-items: center;
}

.remember-me input[type="checkbox"] {
    margin-right: 8px;
}

.forgot-password {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.forgot-password:hover {
    color: var(--secondary-color);
    text-decoration: underline;
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

.btn-block {
    width: 100%;
    padding: 14px;
}

/* Auth Footer */
.auth-footer {
    text-align: center;
    padding: 20px 30px 30px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.register-link {
    color: var(--primary-color);
    font-weight: 500;
    transition: color 0.3s ease;
}

.register-link:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

/* Auth Features */
.auth-features {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 30px;
}

.auth-feature {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.auth-feature:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(255, 107, 107, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 15px;
}

.auth-feature h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.auth-feature p {
    color: var(--gray-color);
    line-height: 1.6;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .auth-container {
        grid-template-columns: 1fr;
    }
    
    .auth-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .auth-container {
        margin: 30px auto 60px;
    }
    
    .auth-header {
        padding: 25px 20px;
    }
    
    .auth-form {
        padding: 25px 20px;
    }
    
    .form-options {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .auth-features {
        grid-template-columns: 1fr;
    }
}

/* Animation classes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.slide-in {
    animation: slideIn 0.8s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const passwordToggle = document.querySelector('.password-toggle');
    const passwordField = document.getElementById('password');
    
    if (passwordToggle && passwordField) {
        passwordToggle.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Change the icon based on password visibility
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    }
    
    // GSAP animations if available
    if (typeof gsap !== 'undefined') {
        gsap.from('.auth-card', {
            duration: 0.8,
            y: 30,
            opacity: 0,
            ease: 'power2.out'
        });
        
        gsap.from('.auth-feature', {
            duration: 0.8,
            x: 30,
            opacity: 0,
            stagger: 0.2,
            delay: 0.3,
            ease: 'power2.out'
        });
    } else {
        // Fallback CSS animations
        document.querySelector('.auth-card').classList.add('slide-in');
        
        document.querySelectorAll('.auth-feature').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-in');
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>