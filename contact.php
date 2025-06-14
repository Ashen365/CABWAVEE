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
    <h2><i class="fas fa-envelope"></i> Contact Us</h2>
    <p>Have questions or feedback? We'd love to hear from you!</p>
</div>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="contact-container">
    <div class="contact-info card">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Get In Touch</h3>
        </div>
        <div class="card-body">
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-text">
                    <h4>Address</h4>
                    <p>123 Cab Street, Transport City</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="info-text">
                    <h4>Phone</h4>
                    <p>+1 (555) 123-4567</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div class="info-text">
                    <h4>Email</h4>
                    <p>info@cabwave.com</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-clock"></i></div>
                <div class="info-text">
                    <h4>Working Hours</h4>
                    <p>24/7 Customer Support</p>
                </div>
            </div>
            
            <div class="social-links">
                <h4><i class="fas fa-share-alt"></i> Follow Us</h4>
                <div class="social-icons">
                    <a href="#" class="social-icon facebook" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon twitter" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon instagram" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon linkedin" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="contact-form card">
        <div class="card-header">
            <h3><i class="fas fa-paper-plane"></i> Send us a Message</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="" id="contactForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Name</label>
                    <input type="text" id="name" name="name" required placeholder="Your name">
                    <span class="error" id="nameError"></span>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required placeholder="Your email address">
                    <span class="error" id="emailError"></span>
                </div>
                
                <div class="form-group">
                    <label for="subject"><i class="fas fa-tag"></i> Subject</label>
                    <input type="text" id="subject" name="subject" required placeholder="Message subject">
                    <span class="error" id="subjectError"></span>
                </div>
                
                <div class="form-group">
                    <label for="message"><i class="fas fa-comment-alt"></i> Message</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Your message"></textarea>
                    <span class="error" id="messageError"></span>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
        </div>
    </div>
</div>

<div class="map-container card">
    <div class="card-header">
        <h3><i class="fas fa-map-marked-alt"></i> Our Location</h3>
    </div>
    <div class="card-body">
        <!-- In a real application, you would embed a Google Map or another map service here -->
        <div class="map-placeholder">
            <div class="map-content">
                <div class="map-pin"><i class="fas fa-map-pin"></i></div>
                <div class="map-address">
                    <h4>CABWAVE Headquarters</h4>
                    <p>123 Cab Street, Transport City</p>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-sm"><i class="fas fa-directions"></i> Get Directions</a>
                </div>
            </div>
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

/* Contact Container */
.contact-container {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 30px;
    margin-bottom: 40px;
}

/* Card Styling */
.card {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.card-header {
    background: linear-gradient(to right, var(--primary-color), #5a74f1);
    color: white;
    padding: 20px 25px;
}

.card-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.card-header h3 i {
    margin-right: 10px;
}

.card-body {
    padding: 25px;
}

/* Contact Info Styles */
.info-item {
    display: flex;
    margin-bottom: 25px;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(255, 107, 107, 0.1));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--primary-color);
    margin-right: 15px;
}

.info-text {
    flex: 1;
}

.info-text h4 {
    margin: 0 0 5px;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.info-text p {
    margin: 0;
    color: var(--text-color);
}

/* Social Links */
.social-links {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.social-links h4 {
    margin-bottom: 15px;
    color: var(--dark-color);
    display: flex;
    align-items: center;
}

.social-links h4 i {
    margin-right: 10px;
    color: var(--primary-color);
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.social-icon:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.social-icon.facebook {
    background: #3b5998;
}

.social-icon.twitter {
    background: #1da1f2;
}

.social-icon.instagram {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}

.social-icon.linkedin {
    background: #0077b5;
}

/* Form Styling */
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
input[type="email"],
textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    outline: none;
}

input::placeholder,
textarea::placeholder {
    color: #a0aec0;
}

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

.btn-sm {
    padding: 8px 15px;
    font-size: 0.9rem;
}

/* Map Styles */
.map-container {
    margin-bottom: 50px;
}

.map-placeholder {
    background-color: #f5f5f5;
    background-image: url('https://maps.googleapis.com/maps/api/staticmap?center=Transport+City&zoom=14&size=1200x400&key=YOUR_API_KEY');
    background-position: center;
    background-size: cover;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.map-content {
    background-color: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    max-width: 400px;
}

.map-pin {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-right: 20px;
}

.map-address h4 {
    margin: 0 0 10px;
    color: var(--dark-color);
}

.map-address p {
    margin: 0 0 15px;
    color: var(--text-color);
}

/* Error Message */
.error {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 5px;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .contact-container {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 1.8rem;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .map-placeholder {
        height: 300px;
    }
    
    .map-content {
        flex-direction: column;
        text-align: center;
    }
    
    .map-pin {
        margin: 0 0 15px;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            
            // Name validation
            const name = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            if (!name.value.trim()) {
                nameError.textContent = 'Name is required';
                valid = false;
            } else {
                nameError.textContent = '';
            }
            
            // Email validation
            const email = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            if (!email.value.trim()) {
                emailError.textContent = 'Email is required';
                valid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email.value)) {
                emailError.textContent = 'Please enter a valid email address';
                valid = false;
            } else {
                emailError.textContent = '';
            }
            
            // Subject validation
            const subject = document.getElementById('subject');
            const subjectError = document.getElementById('subjectError');
            if (!subject.value.trim()) {
                subjectError.textContent = 'Subject is required';
                valid = false;
            } else {
                subjectError.textContent = '';
            }
            
            // Message validation
            const message = document.getElementById('message');
            const messageError = document.getElementById('messageError');
            if (!message.value.trim()) {
                messageError.textContent = 'Message is required';
                valid = false;
            } else {
                messageError.textContent = '';
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
    
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
            
            gsap.from('.contact-info', {
                scrollTrigger: {
                    trigger: '.contact-container',
                    start: 'top 80%'
                },
                duration: 0.8,
                x: -30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.contact-form', {
                scrollTrigger: {
                    trigger: '.contact-container',
                    start: 'top 80%'
                },
                duration: 0.8,
                x: 30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.map-container', {
                scrollTrigger: {
                    trigger: '.map-container',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out'
            });
            
            gsap.from('.info-item', {
                scrollTrigger: {
                    trigger: '.contact-info',
                    start: 'top 80%'
                },
                duration: 0.5,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.3
            });
            
            gsap.from('.social-icon', {
                scrollTrigger: {
                    trigger: '.social-links',
                    start: 'top 90%'
                },
                duration: 0.5,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'back.out(1.7)',
                delay: 0.5
            });
        } else {
            // Fallback animations without ScrollTrigger
            gsap.from('.contact-info', {
                duration: 0.8,
                x: -30,
                opacity: 0,
                ease: 'power2.out',
                delay: 0.5
            });
            
            gsap.from('.contact-form', {
                duration: 0.8,
                x: 30,
                opacity: 0,
                ease: 'power2.out',
                delay: 0.5
            });
            
            gsap.from('.map-container', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'power2.out',
                delay: 1.2
            });
            
            gsap.from('.info-item', {
                duration: 0.5,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.8
            });
            
            gsap.from('.social-icon', {
                duration: 0.5,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'back.out(1.7)',
                delay: 1
            });
        }
    } else {
        // Fallback CSS animations
        document.querySelectorAll('.page-header h2, .page-header p').forEach(el => {
            el.classList.add('fade-in');
        });
        
        document.querySelector('.contact-info').classList.add('slide-up');
        document.querySelector('.contact-form').classList.add('slide-up');
        document.querySelector('.map-container').classList.add('slide-up');
        
        document.querySelectorAll('.info-item').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
        
        document.querySelectorAll('.social-icon').forEach((el, index) => {
            el.style.animationDelay = (0.1 * index) + 's';
            el.classList.add('slide-up');
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>