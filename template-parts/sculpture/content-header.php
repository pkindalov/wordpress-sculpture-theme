<?php
/**
 * Sculpture Header Component
 * Title and short description
 */
?>
<div class="sculpture-header">
    <h1><?php the_title(); ?></h1>
    
    <?php if ($short_desc = get_field('short_description')): ?>
        <p class="subtitle"><?php echo esc_html($short_desc); ?></p>
    <?php endif; ?>
</div>