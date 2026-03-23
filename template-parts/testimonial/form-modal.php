<?php
/**
 * Testimonial Submission Modal Form
 * 
 * @package Sculpture_Theme
 */

// Get translated labels
$share_experience_label = sculpture_translate('Share Your Experience', 'buttons');
$modal_subtitle_label = sculpture_translate('Your feedback helps us improve and helps others make informed decisions', 'common');
$your_name_label = sculpture_translate('Your Name', 'common');
$your_email_label = sculpture_translate('Email Address', 'common');
$display_information_label = sculpture_translate('Will not be displayed publicly', 'common');
$company_position_label = sculpture_translate('Company / Position', 'common');
$company_position_example_label = sculpture_translate('CEO at Company Name', 'common');
$rating_label = sculpture_translate('Rating', 'common');
$testimonial_msg_label = sculpture_translate('Your Testimonial', 'common');
$display_rating_public_label = sculpture_translate('Display my rating publicly', 'common');
$submit_testimonial_label = sculpture_translate('Submit Testimonial', 'buttons');
?>

<!-- Modal Overlay -->
<div id="testimonial-modal" class="testimonial-modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        
        <!-- Close Button -->
        <button class="modal-close" id="close-modal">×</button>
        
        <!-- Modal Content -->
        <div class="modal-content">
            
            <header class="modal-header">
                <h2 class="modal-title"><?php echo $share_experience_label; ?></h2>
                <p class="modal-subtitle"><?php echo $modal_subtitle_label; ?></p>
            </header>
            
            <!-- Form -->
            <form id="testimonial-form" class="testimonial-form">
                
                <?php wp_nonce_field('submit_testimonial', 'testimonial_nonce'); ?>
                
                <!-- Name -->
                <div class="form-group">
                    <label for="testimonial-name">
                        <?php echo $your_name_label; ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-name" 
                        name="client_name" 
                        required 
                        placeholder="<?php echo esc_attr($your_name_label); ?>"
                    >
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="testimonial-email">
                        <?php echo $your_email_label; ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="testimonial-email" 
                        name="client_email" 
                        required 
                        placeholder="<?php echo esc_attr($your_email_label); ?>"
                    >
                    <small class="form-help"><?php echo $display_information_label; ?></small>
                </div>
                
                <!-- Company/Position -->
                <div class="form-group">
                    <label for="testimonial-company">
                        <?php echo $company_position_label; ?>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-company" 
                        name="client_company" 
                        placeholder="<?php echo esc_attr($company_position_example_label); ?>"
                    >
                </div>
                
                <!-- Rating -->
                <div class="form-group">
                    <label for="testimonial-rating">
                        <?php echo $rating_label; ?> <span class="required">*</span>
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
                        <?php echo $testimonial_msg_label; ?> <span class="required">*</span>
                    </label>
                    <textarea 
                        id="testimonial-message" 
                        name="message" 
                        rows="5" 
                        required
                        placeholder="<?php echo esc_attr($share_experience_label); ?>..."
                    ></textarea>
                </div>
                
                <!-- Show Rating Option -->
                <div class="form-group form-checkbox">
                    <label>
                        <input type="checkbox" name="show_rating" value="1" checked>
                        <span><?php echo $display_rating_public_label; ?></span>
                    </label>
                </div>
                
                <!-- Messages -->
                <div id="form-messages" class="form-messages" style="display: none;"></div>
                
                <!-- Submit -->
                <div class="form-actions">
                    <button type="submit" class="submit-button" id="submit-testimonial">
                        <span class="button-text"><?php echo $submit_testimonial_label; ?></span>
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