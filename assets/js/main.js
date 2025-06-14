/**
 * CABWAVE - Main JavaScript File
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initFormValidation();
    initBookingForm();
    initMobileMenu();
});

/**
 * Form Validation
 */
function initFormValidation() {
    // Contact form validation
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
            } else if (!isValidEmail(email.value)) {
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
    
    // Registration form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let valid = true;
            
            // Password validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordError = document.getElementById('passwordError');
            
            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    if (passwordError) {
                        passwordError.textContent = 'Passwords do not match';
                    }
                    valid = false;
                } else if (password.value.length < 6) {
                    if (passwordError) {
                        passwordError.textContent = 'Password must be at least 6 characters';
                    }
                    valid = false;
                } else {
                    if (passwordError) {
                        passwordError.textContent = '';
                    }
                }
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
}

/**
 * Booking Form Enhancement
 */
function initBookingForm() {
    const bookingForm = document.querySelector('form[action*="dashboard.php"]');
    if (bookingForm) {
        // Add location suggestions (this would be more advanced in a real app)
        const pickupLocation = document.getElementById('pickup_location');
        if (pickupLocation) {
            pickupLocation.addEventListener('focus', function() {
                // In a real app, you might fetch suggestions from an API
                console.log('Getting location suggestions...');
            });
        }
        
        // Calculate estimated fare (simplified)
        const dropoffLocation = document.getElementById('dropoff_location');
        if (dropoffLocation && pickupLocation) {
            dropoffLocation.addEventListener('blur', function() {
                if (pickupLocation.value && dropoffLocation.value) {
                    // In a real app, you would call a distance API to calculate fare
                    const fareEstimateElement = document.getElementById('fare-estimate');
                    if (fareEstimateElement) {
                        // Simulate fare calculation
                        const baseFare = 50; // This would come from your pricing table
                        const randomDistance = Math.floor(Math.random() * 10) + 1;
                        const estimatedFare = baseFare + (randomDistance * 10);
                        
                        fareEstimateElement.textContent = `Estimated fare: ₹${estimatedFare} (${randomDistance} km)`;
                    }
                }
            });
        }
    }
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('nav ul');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
    
    // Add menu toggle button if it doesn't exist yet and we're on mobile
    if (!menuToggle && navMenu && window.innerWidth < 768) {
        const header = document.querySelector('header .container');
        if (header) {
            const toggle = document.createElement('button');
            toggle.className = 'menu-toggle';
            toggle.innerHTML = '<span></span><span></span><span></span>';
            header.appendChild(toggle);
            
            toggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                toggle.classList.toggle('active');
            });
        }
    }
}

/**
 * Helper Functions
 */
function isValidEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Add dynamic styles for mobile menu
 */
if (document.querySelector('header')) {
    const style = document.createElement('style');
    style.textContent = `
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                width: 30px;
                height: 21px;
                background: transparent;
                border: none;
                cursor: pointer;
                padding: 0;
                z-index: 10;
            }
            
            .menu-toggle span {
                display: block;
                width: 100%;
                height: 3px;
                background-color: white;
                border-radius: 3px;
                transition: all 0.3s ease;
            }
            
            .menu-toggle.active span:nth-child(1) {
                transform: translateY(9px) rotate(45deg);
            }
            
            .menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            
            .menu-toggle.active span:nth-child(3) {
                transform: translateY(-9px) rotate(-45deg);
            }
            
            nav ul {
                display: none;
            }
            
            nav ul.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background-color: var(--dark-color);
                z-index: 1000;
                padding: 10px;
            }
        }
    `;
    document.head.appendChild(style);
}