<?php
require_once 'includes/header.php';

$error = '';
$success = '';

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = sanitize($_POST['phone']);
    
    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            // Hash password
            $hashed_password = md5($password); // Note: MD5 is not secure, consider using password_hash in production
            
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, phone, role) VALUES (?, ?, ?, ?, 'user')");
            $stmt->bind_param("ssss", $username, $hashed_password, $email, $phone);
            
            if ($stmt->execute()) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
        
        $stmt->close();
    }
}
?>

<div class="register-container">
    <div class="register-card">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <div class="success-content">
                    <h3>Registration Successful!</h3>
                    <p><?php echo $success; ?></p>
                    <a href="login.php" class="btn btn-primary">Go to Login</a>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" action="" id="registrationForm">
                <div class="form-field">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" required placeholder="Choose a username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    <span class="helper-text">Username must be unique</span>
                </div>
                
                <div class="form-field">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required placeholder="Your email address" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <span class="helper-text">We'll never share your email</span>
                </div>
                
                <div class="form-field">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your phone number (optional)" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    <span class="helper-text">For booking notifications</span>
                </div>
                
                <div class="form-row">
                    <div class="form-field">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" required placeholder="Create a password" oninput="checkPasswordStrength()">
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-meter">
                                <div class="strength-meter-fill" id="strengthMeter"></div>
                            </div>
                            <span class="strength-text" id="strengthText">Password strength</span>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                        <div class="password-input">
                            <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password" oninput="checkPasswordMatch()">
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm_password', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="password-match" id="passwordMatch"></span>
                    </div>
                </div>
                
                <div class="terms-checkbox">
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" required>
                        <span class="checkmark"></span>
                        <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-submit">Create Account</button>
                
                <div class="login-link">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <div class="benefits-panel">
        <div class="logo-container">
            <img src="assets/images/logo.svg" alt="CABWAVE Logo" class="logo">
        </div>
        
        <h2>Benefits of joining CABWAVE</h2>
        
        <div class="benefits-list">
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-clock"></i></div>
                <div class="benefit-text">
                    <h4>Save Time</h4>
                    <p>Quick booking process & faster pickups</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-tag"></i></div>
                <div class="benefit-text">
                    <h4>Exclusive Offers</h4>
                    <p>Special discounts for registered users</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="benefit-text">
                    <h4>Secure Payments</h4>
                    <p>Safe & easy payment options</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-history"></i></div>
                <div class="benefit-text">
                    <h4>Booking History</h4>
                    <p>Track all your past & upcoming rides</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #4361EE;
    --light-primary: #EDF2FF;
    --error-color: #FF3B30;
    --success-color: #34C759;
    --text-color: #333333;
    --light-text: #8E8E93;
    --border-color: #E2E8F0;
    --input-bg: #FFFFFF;
    --card-bg: #FFFFFF;
    --benefits-bg: #4361EE;
}

/* Main container */
.register-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1100px;
    margin: 40px auto;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    overflow: hidden;
    background: white;
}

/* Form card */
.register-card {
    padding: 40px;
    background: var(--card-bg);
    overflow-y: auto;
    max-height: 700px;
}

/* Form styles */
.form-field {
    margin-bottom: 20px;
}

.form-field label {
    display: flex;
    align-items: center;
    font-size: 15px;
    font-weight: 500;
    color: var(--text-color);
    margin-bottom: 8px;
}

.form-field label i {
    margin-right: 8px;
    color: var(--primary-color);
    font-size: 14px;
}

.form-field input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background-color: var(--input-bg);
    font-size: 15px;
    transition: all 0.2s ease;
}

.form-field input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
    outline: none;
}

.helper-text {
    display: block;
    margin-top: 5px;
    color: var(--light-text);
    font-size: 13px;
}

/* Password input */
.password-input {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--light-text);
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.toggle-password:hover {
    color: var(--primary-color);
}

/* Password strength meter */
.password-strength {
    margin-top: 8px;
}

.strength-meter {
    height: 4px;
    background-color: #E2E8F0;
    border-radius: 2px;
    overflow: hidden;
}

.strength-meter-fill {
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background-color 0.3s ease;
}

.strength-text {
    display: block;
    font-size: 12px;
    margin-top: 4px;
    color: var(--light-text);
}

/* Password match message */
.password-match {
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

/* Terms checkbox */
.terms-checkbox {
    margin: 25px 0;
}

.checkbox-container {
    display: flex;
    align-items: flex-start;
    position: relative;
    cursor: pointer;
    font-size: 14px;
    color: var(--text-color);
    padding-left: 28px;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: var(--input-bg);
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.checkbox-container:hover input ~ .checkmark {
    background-color: var(--light-primary);
}

.checkbox-container input:checked ~ .checkmark {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.checkbox-container .checkmark:after {
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-container a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.checkbox-container a:hover {
    text-decoration: underline;
}

/* Submit button */
.btn-submit {
    width: 100%;
    padding: 14px;
    margin-top: 10px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background-color: #3651D4;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

/* Login link */
.login-link {
    text-align: center;
    margin-top: 25px;
    font-size: 14px;
    color: var(--text-color);
}

.login-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.login-link a:hover {
    text-decoration: underline;
}

/* Form row */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Benefits panel */
.benefits-panel {
    background: var(--benefits-bg);
    color: white;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.logo-container {
    margin-bottom: 30px;
    text-align: center;
}

.logo {
    height: 60px;
    width: auto;
}

.benefits-panel h2 {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 100%;
}

.benefit-item {
    display: flex;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.benefit-item:hover {
    transform: translateX(5px);
    background-color: rgba(255, 255, 255, 0.2);
}

.benefit-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-right: 15px;
}

.benefit-text h4 {
    margin: 0 0 5px;
    font-size: 16px;
    font-weight: 600;
}

.benefit-text p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
}

/* Alert styles */
.alert {
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.alert i {
    margin-right: 10px;
}

.alert-danger {
    background-color: rgba(255, 59, 48, 0.1);
    color: var(--error-color);
    border-left: 3px solid var(--error-color);
}

/* Success message */
.success-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 40px 20px;
}

.success-message i {
    font-size: 60px;
    color: var(--success-color);
    margin-bottom: 20px;
}

.success-message h3 {
    font-size: 24px;
    color: var(--text-color);
    margin-bottom: 10px;
}

.success-message p {
    color: var(--light-text);
    margin-bottom: 30px;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background-color: #3651D4;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

/* Responsive design */
@media (max-width: 992px) {
    .register-container {
        grid-template-columns: 1fr;
        margin: 20px;
    }
    
    .benefits-panel {
        display: none;
    }
    
    .register-card {
        max-height: none;
        padding: 30px 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>

<script>
// Toggle password visibility
function togglePasswordVisibility(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Check password strength
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const meter = document.getElementById('strengthMeter');
    const text = document.getElementById('strengthText');
    
    // Reset
    meter.style.width = '0';
    meter.style.backgroundColor = '#e2e8f0';
    
    if (!password) {
        text.textContent = 'Password strength';
        text.style.color = 'var(--light-text)';
        return;
    }
    
    // Check strength
    let strength = 0;
    const patterns = [
        /.{6,}/, // At least 6 chars
        /[a-z]/, // Lowercase
        /[A-Z]/, // Uppercase
        /[0-9]/, // Numbers
        /[^a-zA-Z0-9]/ // Special chars
    ];
    
    patterns.forEach(pattern => {
        if (pattern.test(password)) {
            strength++;
        }
    });
    
    // Update meter
    const percentage = (strength / 5) * 100;
    meter.style.width = `${percentage}%`;
    
    // Update color and text
    if (strength < 2) {
        meter.style.backgroundColor = '#FF3B30'; // Red
        text.textContent = 'Weak';
        text.style.color = '#FF3B30';
    } else if (strength < 4) {
        meter.style.backgroundColor = '#FF9500'; // Amber
        text.textContent = 'Medium';
        text.style.color = '#FF9500';
    } else {
        meter.style.backgroundColor = '#34C759'; // Green
        text.textContent = 'Strong';
        text.style.color = '#34C759';
    }
}

// Check if passwords match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const matchText = document.getElementById('passwordMatch');
    
    if (!confirmPassword) {
        matchText.textContent = '';
        return;
    }
    
    if (password === confirmPassword) {
        matchText.textContent = 'Passwords match';
        matchText.style.color = 'var(--success-color)';
    } else {
        matchText.textContent = 'Passwords do not match';
        matchText.style.color = 'var(--error-color)';
    }
}

// Form validation and initialization
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Username validation
            const username = document.getElementById('username');
            if (username.value.trim() === '') {
                isValid = false;
            }
            
            // Email validation
            const email = document.getElementById('email');
            if (email.value.trim() === '' || !email.value.includes('@')) {
                isValid = false;
            }
            
            // Password validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            if (password.value.length < 6) {
                isValid = false;
            }
            
            if (password.value !== confirmPassword.value) {
                isValid = false;
            }
            
            // Terms checkbox
            const terms = document.querySelector('input[name="terms"]');
            if (!terms.checked) {
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    
    // Initialize password strength and match
    if (document.getElementById('password')) {
        checkPasswordStrength();
    }
    
    if (document.getElementById('confirm_password')) {
        checkPasswordMatch();
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>