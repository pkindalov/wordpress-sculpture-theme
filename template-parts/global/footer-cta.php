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
?>

<section class="footer-cta-section">
    <div class="footer-cta-container">
        <h2 class="footer-cta-title"><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['Interested in a Commission?'] : common_translations['en']['Интересувате ли се от изработка по поръчка?']); ?></h2>
        <p class="footer-cta-text"><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']["Let's create something unique together. Contact us to discuss your vision"] : common_translations['en']['Нека създадем нещо уникално заедно. Свържете се с нас, за да обсъдим вашата идея.']); ?></p>
        <a href="<?php echo esc_url(
            home_url("/contact"),
        ); ?>" class="btn-footer-cta">
           <?php echo (get_current_active_language() === 'bg' ? buttons['bg']['Get in Touch'] : buttons['en']['Свържете се с нас']); ?>
        </a>
    </div>
</section>
