<?php
require_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

// Get user data
$user = null;
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    redirect('dashboard.php');
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($email)) {
        $error = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check if email is already in use by another user
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->bind_param("si", $email, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email is already in use by another account";
        } else {
            // If password change is requested
            if (!empty($current_password)) {
                // Verify current password
                $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_data = $result->fetch_assoc();
                
                if (md5($current_password) !== $user_data['password']) { // Note: MD5 is not secure
                    $error = "Current password is incorrect";
                } elseif (empty($new_password) || empty($confirm_password)) {
                    $error = "New password and confirmation are required";
                } elseif ($new_password !== $confirm_password) {
                    $error = "New passwords do not match";
                } elseif (strlen($new_password) < 6) {
                    $error = "New password must be at least 6 characters";
                } else {
                    // Update user with new password
                    $hashed_password = md5($new_password); // Note: MD5 is not secure
                    $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, password = ? WHERE user_id = ?");
                    $stmt->bind_param("sssi", $email, $phone, $hashed_password, $_SESSION['user_id']);
                    
                    if ($stmt->execute()) {
                        $success = "Profile updated successfully with new password";
                    } else {
                        $error = "Failed to update profile: " . $conn->error;
                    }
                }
            } else {
                // Update user without changing password
                $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ? WHERE user_id = ?");
                $stmt->bind_param("ssi", $email, $phone, $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $success = "Profile updated successfully";
                } else {
                    $error = "Failed to update profile: " . $conn->error;
                }
            }
        }
    }
}
?>

<div class="page-header">
    <h2>Edit Profile</h2>
    <p>Update your personal information</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="profile-container">
    <form method="POST" action="" id="profileForm">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" value="<?php echo $user['username']; ?>" readonly disabled>
            <small>Username cannot be changed</small>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            <span class="error" id="emailError"></span>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
        </div>
        
        <h3>Change Password</h3>
        <p class="form-note">Leave blank if you don't want to change your password</p>
        
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password">
        </div>
        
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password">
            <span class="error" id="passwordError"></span>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password">
            <span class="error" id="confirmError"></span>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn">Update Profile</button>
            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<style>
.profile-container {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 25px;
}

.form-note {
    color: #666;
    margin-bottom: 15px;
    font-style: italic;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

h3 {
    margin-top: 30px;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const currentPassword = document.getElementById('current_password');
    const passwordError = document.getElementById('passwordError');
    const confirmError = document.getElementById('confirmError');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            let valid = true;
            
            // If any password field is filled, all password fields are required
            if (newPassword.value || confirmPassword.value || currentPassword.value) {
                if (!currentPassword.value) {
                    if (passwordError) passwordError.textContent = 'Current password is required to change password';
                    valid = false;
                }
                
                if (newPassword.value !== confirmPassword.value) {
                    if (confirmError) confirmError.textContent = 'Passwords do not match';
                    valid = false;
                } else if (newPassword.value && newPassword.value.length < 6) {
                    if (passwordError) passwordError.textContent = 'Password must be at least 6 characters';
                    valid = false;
                }
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>