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
add_filter('body_class', 'sculpture_body_classes');