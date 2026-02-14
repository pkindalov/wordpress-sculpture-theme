<?php
/**
 * Sculpture Description Component
 * Main content area
 */

if (!get_the_content()) {
    return;
}
?>

<div class="sculpture-description">
    <h2>About This Work</h2>
    <?php the_content(); ?>
</div>