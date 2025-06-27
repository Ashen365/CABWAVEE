// Testimonial Slider Script
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.testimonial-slide');
    const dots = document.querySelectorAll('.testimonial-dot');
    const prevBtn = document.querySelector('.testimonial-nav.prev');
    const nextBtn = document.querySelector('.testimonial-nav.next');
    let currentIndex = 0;
    
    // Function to show a slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Remove active class from all dots
        dots.forEach(dot => {
            dot.classList.remove('active');
        });
        
        // Show the current slide and activate corresponding dot
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        currentIndex = index;
    }
    
    // Event listeners for dots
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            showSlide(index);
        });
    });
    
    // Event listeners for next/prev buttons
    prevBtn.addEventListener('click', function() {
        let index = currentIndex - 1;
        if (index < 0) index = slides.length - 1;
        showSlide(index);
    });
    
    nextBtn.addEventListener('click', function() {
        let index = currentIndex + 1;
        if (index >= slides.length) index = 0;
        showSlide(index);
    });
    
    // Auto rotate slides every 5 seconds
    setInterval(() => {
        let index = currentIndex + 1;
        if (index >= slides.length) index = 0;
        showSlide(index);
    }, 5000);
    
    // Add hover animations
    const cards = document.querySelectorAll('.testimonial-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -5,
                boxShadow: '0 15px 30px rgba(0,0,0,0.1)',
                duration: 0.3
            });
        });
        
        card.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                boxShadow: '0 10px 25px rgba(0,0,0,0.15)',
                duration: 0.3
            });
        });
    });
});