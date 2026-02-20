<?php
/**
 * Testimonial Card
 *
 * Template part for displaying a testimonial
 *
 * @package Sculpture_Theme
 */

$testimonial_id = get_the_ID();
$client_name = get_field("client_name", $testimonial_id);
$client_company = get_field("client_company", $testimonial_id);
$rating = get_field("rating", $testimonial_id);
$show_rating = get_field("show_rating", $testimonial_id);
$featured = get_field("featured", $testimonial_id);

// Use title as fallback for name
if (!$client_name) {
    $client_name = get_the_title();
}
?>

<article class="testimonial-card <?php echo $featured ? "featured" : ""; ?>">
    
    <div class="testimonial-content">
        
        <!-- Quote Icon -->
        <div class="quote-icon">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="currentColor">
                <path d="M10 20c0-5.523 4.477-10 10-10v5c-2.761 0-5 2.239-5 5s2.239 5 5 5v5c-5.523 0-10-4.477-10-10zM25 20c0-5.523 4.477-10 10-10v5c-2.761 0-5 2.239-5 5s2.239 5 5 5v5c-5.523 0-10-4.477-10-10z"/>
            </svg>
        </div>
        
        <!-- Rating (if enabled) -->
        <?php if ($show_rating && $rating): ?>
        <div class="testimonial-rating">
            <?php echo testimonial_get_stars($rating); ?>
        </div>
        <?php endif; ?>
        
        <!-- Message -->
        <div class="testimonial-message">
            <?php the_content(); ?>
        </div>
        
    </div>
    
    <!-- Author Info -->
    <footer class="testimonial-footer">
        <div class="testimonial-author">
            <span class="author-name"><?php echo esc_html(
                $client_name,
            ); ?></span>
            <?php if ($client_company): ?>
                <span class="author-company"><?php echo esc_html(
                    $client_company,
                ); ?></span>
            <?php endif; ?>
        </div>
    </footer>
    
</article>
