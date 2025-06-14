<?php
require_once 'includes/header.php';

$error = '';
$success = '';

// Process contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // In a real application, you would send an email here
        // For demonstration purposes, we'll just show a success message
        
        // Example of email sending code (commented out)
        /*
        $to = "admin@cabwave.com";
        $headers = "From: $email";
        $email_message = "Name: $name\n";
        $email_message .= "Email: $email\n\n";
        $email_message .= $message;
        
        if (mail($to, $subject, $email_message, $headers)) {
            $success = "Your message has been sent. We'll get back to you shortly!";
        } else {
            $error = "Failed to send message. Please try again later.";
        }
        */
        
        // For demo, just show success
        $success = "Your message has been sent. We'll get back to you shortly!";
    }
}
?>

<div class="page-header">
    <h2>Contact Us</h2>
    <p>Have questions or feedback? Reach out to us!</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="contact-container">
    <div class="contact-info">
        <h3>Get In Touch</h3>
        <p><strong>Address:</strong> 123 Cab Street, Transport City</p>
        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
        <p><strong>Email:</strong> info@cabwave.com</p>
        <p><strong>Working Hours:</strong> 24/7</p>
        
        <div class="social-links">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#" class="social-icon">Facebook</a>
                <a href="#" class="social-icon">Twitter</a>
                <a href="#" class="social-icon">Instagram</a>
            </div>
        </div>
    </div>
    
    <div class="contact-form">
        <h3>Send us a Message</h3>
        <form method="POST" action="" id="contactForm">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <span class="error" id="nameError"></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error" id="emailError"></span>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
                <span class="error" id="subjectError"></span>
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <span class="error" id="messageError"></span>
            </div>
            
            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>
</div>

<div class="map-container">
    <h3>Our Location</h3>
    <div class="map">
        <!-- In a real application, you would embed a Google Map or another map service here -->
        <div class="map-placeholder">
            <p>Map integration would be displayed here</p>
        </div>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin-bottom: 30px;
}

.contact-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.contact-info, .contact-form {
    background-color: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.social-links {
    margin-top: 20px;
}

.social-icons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.social-icon {
    padding: 8px 12px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 4px;
    text-decoration: none;
}

.map-container {
    margin-bottom: 30px;
}

.map-placeholder {
    background-color: #f5f5f5;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
</style>

<?php require_once 'includes/footer.php'; ?>