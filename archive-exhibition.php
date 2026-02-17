<?php
/**
 * Archive template for Exhibitions
 * 
 * Displays exhibitions grouped by status: Current → Upcoming → Past
 * 
 * @package Sculpture_Theme
 */

get_header();

// Get exhibitions grouped by status
$grouped_exhibitions = exhibition_get_grouped_by_status();

// Counter за zigzag - продължава между секциите
$global_counter = 0;
?>

<div class="exhibitions-archive-container">
    
    <header class="archive-header">
        <h1 class="archive-title"><?php _e('Exhibitions', 'sculpture-theme'); ?></h1>
        <?php if (get_the_archive_description()): ?>
            <div class="archive-description">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </header>
    
    <div class="exhibitions-timeline">
        
        <!-- CURRENT EXHIBITIONS -->
        <?php if (!empty($grouped_exhibitions['current'])): ?>
        <section class="exhibition-group exhibition-group-current">
            <h2 class="exhibition-group-title"><?php _e('Current Exhibitions', 'sculpture-theme'); ?></h2>
            <div class="exhibition-timeline-list">
                <?php foreach ($grouped_exhibitions['current'] as $post): 
                    setup_postdata($post);
                    $global_counter++;
                    $side_class = ($global_counter % 2 === 1) ? 'timeline-left' : 'timeline-right';
                    set_query_var('timeline_side', $side_class);
                    get_template_part('template-parts/exhibition/timeline-item');
                endforeach; 
                wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- UPCOMING EXHIBITIONS -->
        <?php if (!empty($grouped_exhibitions['upcoming'])): ?>
        <section class="exhibition-group exhibition-group-upcoming">
            <h2 class="exhibition-group-title"><?php _e('Upcoming Exhibitions', 'sculpture-theme'); ?></h2>
            <div class="exhibition-timeline-list">
                <?php foreach ($grouped_exhibitions['upcoming'] as $post): 
                    setup_postdata($post);
                    $global_counter++;
                    $side_class = ($global_counter % 2 === 1) ? 'timeline-left' : 'timeline-right';
                    set_query_var('timeline_side', $side_class);
                    get_template_part('template-parts/exhibition/timeline-item');
                endforeach; 
                wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- PAST EXHIBITIONS -->
        <?php if (!empty($grouped_exhibitions['past'])): ?>
        <section class="exhibition-group exhibition-group-past">
            <h2 class="exhibition-group-title"><?php _e('Past Exhibitions', 'sculpture-theme'); ?></h2>
            <div class="exhibition-timeline-list">
                <?php foreach ($grouped_exhibitions['past'] as $post): 
                    setup_postdata($post);
                    $global_counter++;
                    $side_class = ($global_counter % 2 === 1) ? 'timeline-left' : 'timeline-right';
                    set_query_var('timeline_side', $side_class);
                    get_template_part('template-parts/exhibition/timeline-item');
                endforeach; 
                wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- NO EXHIBITIONS -->
        <?php if (empty($grouped_exhibitions['current']) && 
                  empty($grouped_exhibitions['upcoming']) && 
                  empty($grouped_exhibitions['past'])): ?>
        <div class="no-exhibitions">
            <p><?php _e('No exhibitions found.', 'sculpture-theme'); ?></p>
        </div>
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>