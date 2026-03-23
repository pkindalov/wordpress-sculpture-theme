<?php
/**
 * Sculpture Navigation Component
 * Back to gallery button
 */

// Get translated label
$back_to_gallery_label = sculpture_translate('Back To Gallery', 'buttons');
?>
<div class="sculpture-nav">
    <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-back">
        ← <?php echo $back_to_gallery_label; ?>
    </a>
</div>