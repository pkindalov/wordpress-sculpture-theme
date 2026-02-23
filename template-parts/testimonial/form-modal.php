<?php
/**
 * Testimonial Submission Modal Form
 * 
 * @package Sculpture_Theme
 */
?>

<!-- Modal Overlay -->
<div id="testimonial-modal" class="testimonial-modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        
        <!-- Close Button -->
        <button type="button" class="modal-close" id="close-modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        
        <!-- Modal Content -->
        <div class="modal-content">
            
            <header class="modal-header">
                <h2 class="modal-title"><?php _e(
                    "Share Your Experience",
                    "sculpture-theme",
                ); ?></h2>
                <p class="modal-subtitle"><?php _e(
                    "Your feedback helps us improve and helps others make informed decisions.",
                    "sculpture-theme",
                ); ?></p>
            </header>
            
            <!-- Form -->
            <form id="testimonial-form" class="testimonial-form">
                
                <?php wp_nonce_field(
                    "submit_testimonial",
                    "testimonial_nonce",
                ); ?>
                
                <!-- Name -->
                <div class="form-group">
                    <label for="testimonial-name">
                        <?php _e(
                            "Your Name",
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-name" 
                        name="client_name" 
                        required 
                        placeholder="John Smith"
                    >
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="testimonial-email">
                        <?php _e(
                            "Email Address",
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="testimonial-email" 
                        name="client_email" 
                        required 
                        placeholder="john@example.com"
                    >
                    <small class="form-help"><?php _e(
                        "Will not be displayed publicly",
                        "sculpture-theme",
                    ); ?></small>
                </div>
                
                <!-- Company/Position -->
                <div class="form-group">
                    <label for="testimonial-company">
                        <?php _e("Company / Position", "sculpture-theme"); ?>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-company" 
                        name="client_company" 
                        placeholder="CEO at Company Name"
                    >
                </div>
                
                <!-- Rating -->
                <div class="form-group">
                    <label for="testimonial-rating">
                        <?php _e(
                            "Rating",
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <div class="rating-input">
                        <input type="range" id="testimonial-rating" name="rating" min="1" max="5" value="5" step="1">
                        <div class="rating-display">
                            <span id="rating-value">5</span>
                            <div id="rating-stars"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Message -->
                <div class="form-group">
                    <label for="testimonial-message">
                        <?php _e(
                            "Your Testimonial",
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <textarea 
                        id="testimonial-message" 
                        name="message" 
                        rows="5" 
                        required
                        placeholder="Share your experience..."
                    ></textarea>
                </div>
                
                <!-- Show Rating Option -->
                <div class="form-group form-checkbox">
                    <label>
                        <input type="checkbox" name="show_rating" value="1" checked>
                        <span><?php _e(
                            "Display my rating publicly",
                            "sculpture-theme",
                        ); ?></span>
                    </label>
                </div>
                
                <!-- Messages -->
                <div id="form-messages" class="form-messages" style="display: none;"></div>
                
                <!-- Submit -->
                <div class="form-actions">
                    <button type="submit" class="submit-button" id="submit-testimonial">
                        <span class="button-text"><?php _e(
                            "Submit Testimonial",
                            "sculpture-theme",
                        ); ?></span>
                        <span class="button-loader" style="display: none;">
                            <svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2" opacity="0.25"/>
                                <path d="M12 2a10 10 0 0110 10" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </button>
                </div>
                
            </form>
            
        </div>
        
    </div>
</div>
