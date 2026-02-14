<?php
/**
 * Sculpture Image Component
 * Displays featured image
 */

if (!has_post_thumbnail()) {
    return;
}
?>

<div class="sculpture-image">
    <?php the_post_thumbnail('full'); ?>
</div>