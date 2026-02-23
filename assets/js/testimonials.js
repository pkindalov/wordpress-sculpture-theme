/**
 * Testimonials Modal & Form Handling
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        
        const modal = document.getElementById('testimonial-modal');
        const closeBtn = document.getElementById('close-modal');
        const form = document.getElementById('testimonial-form');
        const ratingInput = document.getElementById('testimonial-rating');
        const ratingValue = document.getElementById('rating-value');
        const ratingStars = document.getElementById('rating-stars');
        const submitBtn = document.getElementById('submit-testimonial');
        const messages = document.getElementById('form-messages');
        
        if (!modal) return;
        
        // Open modal - listen for trigger buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.testimonial-trigger')) {
                e.preventDefault();
                openModal();
            }
        });
        
        // Close modal
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }
        
        // Close on overlay click
        modal.querySelector('.modal-overlay').addEventListener('click', closeModal);
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });
        
       // Open modal function
        function openModal() {
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
        
        // Close modal function
        function closeModal() {
            modal.classList.remove('is-open');
            document.body.style.overflow = '';
        }
        
        // Update rating display
        if (ratingInput) {
            updateRatingDisplay(ratingInput.value);
            
            ratingInput.addEventListener('input', function() {
                updateRatingDisplay(this.value);
            });
        }
        
        function updateRatingDisplay(value) {
            ratingValue.textContent = value;
            
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= value) {
                    starsHTML += '<svg class="star filled" width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z"/></svg>';
                } else {
                    starsHTML += '<svg class="star empty" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z" stroke-width="1.5"/></svg>';
                }
            }
            ratingStars.innerHTML = starsHTML;
        }
        
        // Form submission
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Disable button
                submitBtn.disabled = true;
                submitBtn.querySelector('.button-text').style.display = 'none';
                submitBtn.querySelector('.button-loader').style.display = 'flex';
                
                // Hide previous messages
                messages.style.display = 'none';
                
                // Prepare data
                const formData = new FormData(form);
                formData.append('action', 'submit_testimonial');
                
                // AJAX request
                fetch(sculptureTheme.ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('success', data.data.message);
                        form.reset();
                        updateRatingDisplay(5);
                        
                        // Close modal after 2 seconds
                        setTimeout(function() {
                            closeModal();
                            messages.style.display = 'none';
                        }, 2000);
                    } else {
                        showMessage('error', data.data.message || 'Something went wrong. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Network error. Please try again.');
                })
                .finally(() => {
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.querySelector('.button-text').style.display = 'inline';
                    submitBtn.querySelector('.button-loader').style.display = 'none';
                });
            });
        }
        
        function showMessage(type, text) {
            messages.className = 'form-messages ' + type;
            messages.textContent = text;
            messages.style.display = 'block';
        }
        
        // ========================================
        // TESTIMONIALS SLIDER
        // ========================================
        
        const slider = document.getElementById('testimonials-slider');
        
        if (slider) {
            const track = slider.querySelector('.slider-track');
            const slides = track.querySelectorAll('.testimonial-card');
            const prevBtn = document.getElementById('slider-prev');
            const nextBtn = document.getElementById('slider-next');
            const dotsContainer = document.getElementById('slider-dots');
            
            let currentSlide = 0;
            const totalSlides = slides.length;
            
            // Create dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.className = 'slider-dot';
                dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
            
            const dots = dotsContainer.querySelectorAll('.slider-dot');
            
            // Update slider
            function updateSlider() {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
                
                // Update buttons
                prevBtn.disabled = currentSlide === 0;
                nextBtn.disabled = currentSlide === totalSlides - 1;
            }
            
            // Go to specific slide
            function goToSlide(index) {
                currentSlide = index;
                updateSlider();
            }
            
            // Previous slide
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentSlide > 0) {
                        currentSlide--;
                        updateSlider();
                    }
                });
            }
            
            // Next slide
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentSlide < totalSlides - 1) {
                        currentSlide++;
                        updateSlider();
                    }
                });
            }
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (slider && isElementInViewport(slider)) {
                    if (e.key === 'ArrowLeft' && currentSlide > 0) {
                        currentSlide--;
                        updateSlider();
                    } else if (e.key === 'ArrowRight' && currentSlide < totalSlides - 1) {
                        currentSlide++;
                        updateSlider();
                    }
                }
            });
            
            // Check if element is in viewport
            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
            
            // Auto-play (optional)
            let autoplayInterval;
            
            function startAutoplay() {
                autoplayInterval = setInterval(() => {
                    if (currentSlide < totalSlides - 1) {
                        currentSlide++;
                    } else {
                        currentSlide = 0;
                    }
                    updateSlider();
                }, 5000); // Change slide every 5 seconds
            }
            
            function stopAutoplay() {
                clearInterval(autoplayInterval);
            }
            
            // Start autoplay
            startAutoplay();
            
            // Pause on hover
            slider.addEventListener('mouseenter', stopAutoplay);
            slider.addEventListener('mouseleave', startAutoplay);
            
            // Initial update
            updateSlider();
        }
        
    });
    
})();
