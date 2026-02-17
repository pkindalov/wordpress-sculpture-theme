<?php
/**
 * Sculpture Navigation Component
 * Back to gallery button
 */
?>

<div class="sculpture-nav">
    <a href="<?php echo esc_url(
        get_post_type_archive_link("sculpture"),
    ); ?>" class="btn-back">
        ← BACK TO GALLERY
    </a>
</div>
