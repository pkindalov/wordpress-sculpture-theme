<?php
/**
 * Sculpture Description Component
 * Displays Gutenberg content
 */

if (get_the_content()):
?>

<div class="sculpture-description">
    <h2>About This Work</h2>
    <?php the_content(); ?>
</div>

<?php endif; ?>