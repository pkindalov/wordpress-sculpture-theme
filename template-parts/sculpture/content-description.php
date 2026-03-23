<?php
/**
 * Sculpture Description Component
 * Main content area
 */
if (!get_the_content()) {
    return;
}

// Get translated label
$about_work_title = sculpture_translate('About This Work', 'common');
?>
<div class="sculpture-description">
    <h2><?php echo $about_work_title; ?></h2>
    <?php the_content(); ?>
</div>