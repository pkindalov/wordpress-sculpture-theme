<?php
/**
 * Exhibition Timeline Item
 * 
 * Template part for displaying a single exhibition in timeline format
 * 
 * @package Sculpture_Theme
 */

// Get exhibition data
$exhibition_id = get_the_ID();
$status = exhibition_get_status($exhibition_id);
$status_label = exhibition_get_status_label($status);
$date_range = exhibition_get_date_range($exhibition_id);
$venue = get_field('venue', $exhibition_id);
$description = get_field('description', $exhibition_id);

// Get side class (left/right) - passes from archive template
$side_class = get_query_var('timeline_side', 'timeline-left');
?>

<article class="exhibition-timeline-item exhibition-status-<?php echo esc_attr($status); ?> <?php echo esc_attr($side_class); ?>">
    
    <!-- Timeline Dot -->
    <div class="exhibition-timeline-dot"></div>
    
    <!-- Content -->
    <div class="exhibition-content">
        
        <!-- Status Badge -->
        <span class="exhibition-status-badge"><?php echo esc_html($status_label); ?></span>
        
        <!-- Title -->
        <h3 class="exhibition-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <!-- Meta Information -->
        <div class="exhibition-meta">
            
            <?php if ($date_range): ?>
            <div class="exhibition-meta-item">
                <svg class="meta-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <rect x="2" y="3" width="12" height="11" rx="1" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 6h12M5 1v2M11 1v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span><?php echo esc_html($date_range); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($venue): ?>
            <div class="exhibition-meta-item">
                <svg class="meta-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 8a2 2 0 100-4 2 2 0 000 4zM8 14c3 0 5-2.5 5-5.5S11 3 8 3 3 5.5 3 8.5 5 14 8 14z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span><?php echo esc_html($venue); ?></span>
            </div>
            <?php endif; ?>
            
        </div>
        
        <!-- Description -->
        <?php if ($description): ?>
        <div class="exhibition-description">
            <?php echo wp_kses_post(wpautop($description)); ?>
        </div>
        <?php endif; ?>
        
    </div>
    
</article>