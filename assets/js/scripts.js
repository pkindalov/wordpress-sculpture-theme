/**
 * Sculpture Theme - Custom JavaScript
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

(function($) {
    'use strict';

    /**
     * Document ready
     */
    $(document).ready(function() {
        initGalleryLightbox();
        initSmoothScroll();
    });

    /**
     * Gallery lightbox initialization
     */
    function initGalleryLightbox() {
        const gallery = $('.sculpture-gallery');
        
        if (gallery.length === 0) {
            return;
        }
        
        const galleryImages = gallery.find('.gallery-item img');
        
        galleryImages.on('click', function() {
            const imgSrc = $(this).attr('src');
            window.open(imgSrc, '_blank');
        });
        
        galleryImages.css('cursor', 'pointer');
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });
    }

    /**
     * Window resize handler (debounced)
     */
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Resize logic here
        }, 250);
    });

})(jQuery);
