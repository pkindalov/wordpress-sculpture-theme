<?php
/**
 * Footer CTA Component
 * 
 * Reusable call-to-action footer section
 * Can be used on any page
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Get translated labels
$cta_title = sculpture_translate('Interested in a Commission?', 'common');
$cta_text = sculpture_translate("Let's create something unique together. Contact us to discuss your vision", 'common');
$cta_button = sculpture_translate('Get in Touch', 'buttons');
?>
<section class="footer-cta-section">
    <div class="footer-cta-container">
        <h2 class="footer-cta-title"><?php echo $cta_title; ?></h2>
        <p class="footer-cta-text"><?php echo $cta_text; ?></p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-footer-cta">
            <?php echo $cta_button; ?>
        </a>
    </div>
</section>