/**
 * CABWAVE - Main JavaScript File
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initFormValidation();
    initBookingForm();
    initTooltips();
    initAnimationObserver();
    
    // Check if Magic UI is loaded and initialize components
    if (typeof MagicUI !== 'undefined') {
        initMagicUI();
    }
});

/**
 * Initialize Magic UI Components
 */
function initMagicUI() {
    // Initialize tooltips
    if (MagicUI.Tooltip) {
        new MagicUI.Tooltip(document.querySelectorAll('[data-tooltip]'));
    }
    
    // Initialize dropdowns
    if (MagicUI.Dropdown) {
        new MagicUI.Dropdown(document.querySelectorAll('.dropdown-toggle'));
    }
    
    // Initialize modals
    if (MagicUI.Modal) {
        new MagicUI.Modal(document.querySelectorAll('[data-toggle="modal"]'));
    }
    
    // Initialize tabs
    if (MagicUI.Tabs) {
        new MagicUI.Tabs(document.querySelectorAll('[data-toggle="tab"]'));
    }
}

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
                        
                        // Add animation to the fare estimate
                        fareEstimateElement.classList.add('highlight-animation');
                        setTimeout(() => {
                            fareEstimateElement.classList.remove('highlight-animation');
                        }, 1500);
                    }
                }
            });
        }
    }
}

/**
 * Initialize Tooltips
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        const tooltipText = element.getAttribute('data-tooltip');
        
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.top = rect.bottom + window.scrollY + 10 + 'px';
            tooltip.style.left = rect.left + window.scrollX + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            
            setTimeout(() => {
                tooltip.classList.add('show');
            }, 10);
            
            element.addEventListener('mouseleave', function handler() {
                tooltip.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(tooltip);
                }, 300);
                element.removeEventListener('mouseleave', handler);
            });
        });
    });
}

/**
 * Initialize Intersection Observer for Animations
 */
function initAnimationObserver() {
    // Only initialize if IntersectionObserver is supported and GSAP is not being used
    if ('IntersectionObserver' in window && typeof gsap === 'undefined') {
        const elements = document.querySelectorAll('.feature, .step, .testimonial, .cta-section');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        elements.forEach(element => {
            observer.observe(element);
        });
    }
}

/**
 * Helper Functions
 */
function isValidEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}