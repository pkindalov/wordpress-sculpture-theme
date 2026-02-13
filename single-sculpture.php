<?php
/**
 * Single Sculpture Template
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="sculpture-single-container">
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="sculpture-<?php the_ID(); ?>" <?php post_class('sculpture-single'); ?>>
            
            <?php
            // Load organized components
            get_template_part('template-parts/sculpture/content', 'header');
            get_template_part('template-parts/sculpture/content', 'info');
            get_template_part('template-parts/sculpture/content', 'description');
            get_template_part('template-parts/sculpture/content', 'navigation');
            ?>
            
        </article>
        
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>