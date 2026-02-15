<?php
/**
 * Template Helper Functions
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get sculpture info field
 * 
 * Helper function to safely get ACF field with fallback
 * 
 * @param string $field_name ACF field name
 * @param int|null $post_id Post ID (null for current post)
 * @param string $default Default value if field is empty
 * @return mixed Field value or default
 */
function sculpture_get_field($field_name, $post_id = null, $default = '') {
    
    if (!function_exists('get_field')) {
        return $default;
    }
    
    $value = get_field($field_name, $post_id);
    
    return $value ? $value : $default;
}

/**
 * Display sculpture info item
 * 
 * Outputs formatted info item (label + value)
 * 
 * @param string $label Display label
 * @param string $field_name ACF field name
 * @param int|null $post_id Post ID
 */
function sculpture_info_item($label, $field_name, $post_id = null) {
    
    $value = sculpture_get_field($field_name, $post_id);
    
    if (!$value) {
        return;
    }
    
    ?>
    <div class="sculpture-info-item">
        <span class="info-label"><?php echo esc_html($label); ?>:</span>
        <span class="info-value"><?php echo esc_html($value); ?></span>
    </div>
    <?php
}

/**
 * Get sculpture gallery
 * 
 * Returns ACF gallery field as array
 * 
 * @param int|null $post_id Post ID
 * @return array|false Gallery images or false
 */
function sculpture_get_gallery($post_id = null) {
    
    if (!function_exists('get_field')) {
        return false;
    }
    
    $gallery = get_field('галерия', $post_id);
    
    return is_array($gallery) && !empty($gallery) ? $gallery : false;
}

/**
 * Display sculpture gallery
 * 
 * Outputs formatted gallery HTML
 * 
 * @param int|null $post_id Post ID
 */
function sculpture_display_gallery($post_id = null) {
    
    $gallery = sculpture_get_gallery($post_id);
    
    if (!$gallery) {
        return;
    }
    
    ?>
    <div class="sculpture-gallery">
        <?php foreach ($gallery as $image): ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url($image['url']); ?>" 
                     alt="<?php echo esc_attr($image['alt']); ?>"
                     loading="lazy">
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Check if current post is sculpture type
 * 
 * @return bool
 */
function is_sculpture() {
    return is_singular('sculpture');
}

/**
 * Custom body classes
 * 
 * Add custom classes to body tag
 * 
 * @param array $classes Existing classes
 * @return array Modified classes
 */
function sculpture_body_classes($classes) {
    
    if (is_sculpture()) {
        $classes[] = 'sculpture-single';
    }
    
    return $classes;
}


/**
 * Featured Sculptures Shortcode
 * 
 * Display sculpture grid on homepage/any page
 * Usage: [featured_sculptures count="6"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_featured_shortcode($atts) {
    
    // Default attributes
    $atts = shortcode_atts(array(
        'count' => 6,
        'featured_only' => false,
    ), $atts);
    
    // Query args
    $query_args = array(
        'post_type'      => 'sculpture',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    // Filter only featured sculptures
    if ($atts['featured_only'] === 'true') {
        $query_args['meta_query'] = array(
            array(
                'key'     => 'featured',
                'value'   => '1',
                'compare' => '=',
            ),
        );
    }
    
    $sculptures = new WP_Query($query_args);
    
    // Start output buffering
    ob_start();
    
    if ($sculptures->have_posts()):
    ?>
    
    <section class="homepage-sculptures">
        
        <div class="homepage-sculptures-header">
            <h2 class="section-title">Featured Works</h2>
            <p class="section-subtitle">Discover our latest sculptures</p>
        </div>
        
        <div class="sculptures-grid sculptures-grid-homepage">
            
            <?php 
            while ($sculptures->have_posts()): 
                $sculptures->the_post();
                
                // Load card component
                get_template_part('template-parts/sculpture/card');
                
            endwhile; 
            ?>
            
        </div>
        
        <div class="homepage-sculptures-footer">
            <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-view-all">
                View All Sculptures →
            </a>
        </div>
        
    </section>
    
    <?php
    endif;
    
    // Reset post data
    wp_reset_postdata();
    
    // Return output
    return ob_get_clean();
}

add_filter('body_class', 'sculpture_body_classes');
add_shortcode('featured_sculptures', 'sculpture_featured_shortcode');