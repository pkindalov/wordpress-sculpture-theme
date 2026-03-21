<?php
/**
 * Sculpture Description Component
 * Main content area
 */

if (!get_the_content()) {
    return;
} ?>

<div class="sculpture-description">
    <h2>
        <?php echo (get_current_active_language() === "bg" ? common_translations['bg']['About This Work'] : common_translations['en']['За Творбата']); ?>
    </h2>
    <?php the_content(); ?>
</div>
