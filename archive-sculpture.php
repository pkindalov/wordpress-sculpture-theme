<?php
/**
 * Archive Sculpture Template - Gallery View
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); 
?>

<div class="sculpture-archive">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <h1 class="archive-title">Sculpture Gallery</h1>
        <p class="archive-subtitle">Explore our collection of original artworks</p>
    </header>

    <!-- Sculptures Grid -->
    <?php if (have_posts()): ?>
        
        <div class="sculptures-grid">
            
            <?php 
            while (have_posts()): 
                the_post();
                
                // Load card component
                get_template_part('template-parts/sculpture/card');
                
            endwhile; 
            ?>
            
        </div>
        
        <!-- Pagination -->
        <?php
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
        ));
        ?>
        
    <?php else: ?>
        
        <div class="no-sculptures">
            <p>No sculptures found.</p>
        </div>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
