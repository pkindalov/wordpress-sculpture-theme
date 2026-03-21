<?php
/**
 * Testimonial Submission Modal Form
 * 
 * @package Sculpture_Theme
 */
$share_experience_label =  get_current_active_language() === 'bg' ? buttons['bg']['Share Your Experience'] : buttons['en']['Напишете отзив'];
$modal_subtitle_label = get_current_active_language() === 'bg' ? common_translations['bg']['Your feedback helps us improve and helps others make informed decisions'] : common_translations['en']['Вашата обратна връзка ни помага да се усъвършенстваме и да помагаме на другите да вземат информирани решения'];
$your_name_label = get_current_active_language() === 'bg' ? common_translations['bg']['Your Name'] : common_translations['en']['Име'];
$your_email_label = get_current_active_language() === 'bg' ? common_translations['bg']['Email Address'] : common_translations['en']['Имейл адрес'];
$display_information_label = get_current_active_language() === 'bg' ? common_translations['bg']['Will not be displayed publicly'] : common_translations['en']['Няма да бъде показано публично'];
$company_position_label = get_current_active_language() === 'bg' ? common_translations['bg']['Company / Position'] : common_translations['en']['Компания / Длъжност'];
$company_position_example_label = get_current_active_language() === 'bg' ? common_translations['bg']['CEO at Company Name'] : common_translations['en']['Главен изпълнителен директор на компанията'];
$rating_label = get_current_active_language() === 'bg' ? common_translations['bg']['Rating'] : common_translations['en']['Оценка'];
$testimonial_msg_label = get_current_active_language() === 'bg' ? common_translations['bg']['Your Testimonial'] : common_translations['en']['Отзив'];
$displate_rating_public_label =  get_current_active_language() === 'bg' ? common_translations['bg']['Display my rating publicly'] : common_translations['en']['Покажи оценката ми публично'];
?>

<!-- Modal Overlay -->
<div id="testimonial-modal" class="testimonial-modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        
        <!-- Close Button -->
        <button class="modal-close" id="close-modal">x</button>
        
        <!-- Modal Content -->
        <div class="modal-content">
            
            <header class="modal-header">
                <h2 class="modal-title"><?php _e(
                    $share_experience_label,
                    "sculpture-theme",
                ); ?></h2>
                <p class="modal-subtitle"><?php _e(
                    $modal_subtitle_label,
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
                            $your_name_label,
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-name" 
                        name="client_name" 
                        required 
                        placeholder="<?php echo $your_name_label; ?>"
                    >
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="testimonial-email">
                        <?php _e(
                            $your_email_label,
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="testimonial-email" 
                        name="client_email" 
                        required 
                        placeholder="<?php echo $your_email_label; ?>"
                    >
                    <small class="form-help"><?php _e(
                        $display_information_label,
                        "sculpture-theme",
                    ); ?></small>
                </div>
                
                <!-- Company/Position -->
                <div class="form-group">
                    <label for="testimonial-company">
                        <?php _e($company_position_label, "sculpture-theme"); ?>
                    </label>
                    <input 
                        type="text" 
                        id="testimonial-company" 
                        name="client_company" 
                        placeholder="<?php echo $company_position_example_label; ?>"
                    >
                </div>
                
                <!-- Rating -->
                <div class="form-group">
                    <label for="testimonial-rating">
                        <?php _e(
                            $rating_label,
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
                            $testimonial_msg_label,
                            "sculpture-theme",
                        ); ?> <span class="required">*</span>
                    </label>
                    <textarea 
                        id="testimonial-message" 
                        name="message" 
                        rows="5" 
                        required
                        placeholder="<?php echo $share_experience_label; ?>..."
                    ></textarea>
                </div>
                
                <!-- Show Rating Option -->
                <div class="form-group form-checkbox">
                    <label>
                        <input type="checkbox" name="show_rating" value="1" checked>
                        <span><?php _e(
                            $displate_rating_public_label,
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
