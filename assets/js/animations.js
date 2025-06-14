document.addEventListener('DOMContentLoaded', function() {
    // Check if GSAP is loaded
    if (typeof gsap !== 'undefined') {
        // Register ScrollTrigger plugin if available
        if (gsap.registerPlugin && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
        }
        
        // Hero section animations
        gsap.from('.hero h1', {
            duration: 1,
            y: 50,
            opacity: 0,
            ease: 'power3.out'
        });
        
        gsap.from('.hero p', {
            duration: 1,
            y: 30,
            opacity: 0,
            ease: 'power3.out',
            delay: 0.3
        });
        
        gsap.from('.hero-buttons .btn', {
            duration: 0.8,
            y: 20,
            opacity: 0,
            ease: 'power3.out',
            delay: 0.6,
            stagger: 0.2
        });
        
        // Features section animations with ScrollTrigger
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.from('.feature', {
                scrollTrigger: {
                    trigger: '.features',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 50,
                opacity: 0,
                ease: 'power2.out',
                stagger: 0.2
            });
            
            gsap.from('.step', {
                scrollTrigger: {
                    trigger: '.how-it-works',
                    start: 'top 80%'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'back.out(1.7)',
                stagger: 0.2
            });
            
            // Testimonials section (if added)
            if (document.querySelector('.testimonial')) {
                gsap.from('.testimonial', {
                    scrollTrigger: {
                        trigger: '.testimonials',
                        start: 'top 80%'
                    },
                    duration: 0.8,
                    y: 40,
                    opacity: 0,
                    ease: 'power2.out',
                    stagger: 0.2
                });
            }
            
            // CTA section (if added)
            if (document.querySelector('.cta-section')) {
                gsap.from('.cta-section h2, .cta-section p, .cta-section .btn', {
                    scrollTrigger: {
                        trigger: '.cta-section',
                        start: 'top 80%'
                    },
                    duration: 0.8,
                    y: 30,
                    opacity: 0,
                    ease: 'power2.out',
                    stagger: 0.2
                });
            }
        } else {
            // Fallback animations if ScrollTrigger is not available
            gsap.from('.feature', {
                duration: 0.8,
                y: 50,
                opacity: 0,
                ease: 'power2.out',
                stagger: 0.2,
                delay: 0.8
            });
            
            gsap.from('.step', {
                duration: 0.8,
                y: 30,
                opacity: 0,
                ease: 'back.out(1.7)',
                stagger: 0.2,
                delay: 1.2
            });
        }
    } else {
        // Fallback for when GSAP is not loaded - use CSS animations
        document.querySelectorAll('.hero h1, .hero p, .hero-buttons, .feature, .step').forEach(elem => {
            elem.classList.add('animate-fade-in');
        });
    }
});