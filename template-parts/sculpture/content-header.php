<?php
/**
 * Sculpture Header Component
 * Displays title, badge, and short description
 */

$featured = get_field('featured');
$short_desc = get_field('short_description');
?>

<header class="sculpture-header">
    <h1 class="sculpture-title"><?php the_title(); ?></h1>
    
    <?php if ($featured): ?>
        <span class="sculpture-badge featured-badge">Featured Work</span>
    <?php endif; ?>
    
    <?php if ($short_desc): ?>
        <div class="sculpture-subtitle">
            <p><?php echo esc_html($short_desc); ?></p>
        </div>
    <?php endif; ?>
</header>

<?php if (has_post_thumbnail()): ?>
    <div class="sculpture-featured-image">
        <?php the_post_thumbnail('large'); ?>
    </div>
<?php endif; ?>