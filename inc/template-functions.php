<?php
/**
 * Template Helper Functions
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit();
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
function sculpture_get_field($field_name, $post_id = null, $default = "")
{
    if (!function_exists("get_field")) {
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
function sculpture_info_item($label, $field_name, $post_id = null)
{
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
function sculpture_get_gallery($post_id = null)
{
    if (!function_exists("get_field")) {
        return false;
    }

    $gallery = get_field("галерия", $post_id);

    return is_array($gallery) && !empty($gallery) ? $gallery : false;
}

/**
 * Display sculpture gallery
 *
 * Outputs formatted gallery HTML
 *
 * @param int|null $post_id Post ID
 */
function sculpture_display_gallery($post_id = null)
{
    $gallery = sculpture_get_gallery($post_id);

    if (!$gallery) {
        return;
    }
    ?>
    <div class="sculpture-gallery">
        <?php foreach ($gallery as $image): ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url($image["url"]); ?>" 
                     alt="<?php echo esc_attr($image["alt"]); ?>"
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
function is_sculpture()
{
    return is_singular("sculpture");
}

/**
 * Custom body classes
 *
 * Add custom classes to body tag
 *
 * @param array $classes Existing classes
 * @return array Modified classes
 */
function sculpture_body_classes($classes)
{
    if (is_sculpture()) {
        $classes[] = "sculpture-single";
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
function sculpture_featured_shortcode($atts)
{
    // Default attributes
    $atts = shortcode_atts(
        [
            "count" => 6,
            "featured_only" => false,
        ],
        $atts,
    );

    // Query args
    $query_args = [
        "post_type" => "sculpture",
        "posts_per_page" => intval($atts["count"]),
        "orderby" => "date",
        "order" => "DESC",
    ];

    // Filter only featured sculptures
    if ($atts["featured_only"] === "true") {
        $query_args["meta_query"] = [
            [
                "key" => "featured",
                "value" => "1",
                "compare" => "=",
            ],
        ];
    }

    $sculptures = new WP_Query($query_args);

    // Start output buffering
    ob_start();

    if ($sculptures->have_posts()): ?>
    
    <section class="homepage-sculptures">
        
        <div class="homepage-sculptures-header">
            <h2 class="section-title">Selected Works</h2>
            <p class="section-subtitle">Discover our latest sculptures</p>
        </div>
        
        <div class="sculptures-grid sculptures-grid-homepage">
            
            <?php while ($sculptures->have_posts()):
                $sculptures->the_post();

                // Load card component
                get_template_part("template-parts/sculpture/card");
            endwhile; ?>
            
        </div>
        
        <div class="homepage-sculptures-footer">
            <a href="<?php echo esc_url(
                get_post_type_archive_link("sculpture"),
            ); ?>" class="btn-view-all">
                View All Sculptures →
            </a>
        </div>
        
    </section>
    
    <?php endif;

    // Reset post data
    wp_reset_postdata();

    // Return output
    return ob_get_clean();
}

/**
 * Check if a sculpture is currently on promotion
 * Checks both on_promotion flag and promotion_ends date
 *
 * @param int $post_id Post ID (optional)
 * @return bool
 */
function sculpture_is_on_promotion($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Check if promotion is enabled
    $on_promotion = get_field("on_promotion", $post_id);
    if (!$on_promotion) {
        return false;
    }

    // Check expiry date if set
    $promotion_ends = get_field("promotion_ends", $post_id);
    if ($promotion_ends) {
        $today = date("Ymd");
        if ($today > $promotion_ends) {
            return false;
        }
    }

    return true;
}

/**
 * Get promotion price for a sculpture
 * Priority: manual price → calculated from % → null
 *
 * @param int $post_id Post ID (optional)
 * @return float|null Promotion price or null
 */
function sculpture_get_promotion_price($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Not on promotion = no price
    if (!sculpture_is_on_promotion($post_id)) {
        return null;
    }

    $price = get_field("price", $post_id);
    $manual = get_field("promotion_price", $post_id);
    $percentage = get_field("promotion_percentage", $post_id);

    // Priority 1: Manual override
    if ($manual) {
        return round($manual, 2);
    }

    // Priority 2: Calculate from percentage
    if ($price && $percentage) {
        return round($price * (1 - $percentage / 100), 2);
    }

    return null;
}

/**
 * Get promotion percentage for display
 *
 * @param int $post_id Post ID (optional)
 * @return int|null Percentage or null
 */
function sculpture_get_promotion_percentage($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!sculpture_is_on_promotion($post_id)) {
        return null;
    }

    $percentage = get_field("promotion_percentage", $post_id);
    $price = get_field("price", $post_id);
    $manual_price = get_field("promotion_price", $post_id);

    // If manual price - calculate actual percentage
    if ($manual_price && $price) {
        return round((1 - $manual_price / $price) * 100);
    }

    return $percentage ? intval($percentage) : null;
}

/**
 * Promotion Sculptures Shortcode
 * Shows only sculptures currently on promotion
 * Returns empty string if no active promotions (section hidden)
 *
 * Usage: [promo_sculptures count="3"]
 */
function sculpture_promo_shortcode($atts)
{
    $atts = shortcode_atts(
        [
            "count" => 3,
        ],
        $atts,
    );

    $today = date("Ymd");

    $sculptures = new WP_Query([
        "post_type" => "sculpture",
        "posts_per_page" => intval($atts["count"]),
        "meta_query" => [
            "relation" => "AND",
            [
                "key" => "on_promotion",
                "value" => "1",
                "compare" => "=",
            ],
            [
                "relation" => "OR",
                [
                    "key" => "promotion_ends",
                    "compare" => "NOT EXISTS",
                ],
                [
                    "key" => "promotion_ends",
                    "value" => "",
                    "compare" => "=",
                ],
                [
                    "key" => "promotion_ends",
                    "value" => $today,
                    "compare" => ">=",
                ],
            ],
        ],
    ]);

    // Hide section completely if no active promotions
    if (!$sculptures->have_posts()) {
        return "";
    }

    ob_start();
    ?>

    <section class="homepage-promo">

        <div class="homepage-promo-header">
            <h2 class="section-title">Special Offers</h2>
            <p class="section-subtitle">Limited time prices on selected original sculptures</p>
        </div>

        <div class="sculptures-grid">
            <?php while ($sculptures->have_posts()):
                $sculptures->the_post();
                get_template_part("template-parts/sculpture/card");
            endwhile; ?>
        </div>

        <div class="homepage-promo-footer">
            <a href="<?php echo esc_url(
                get_post_type_archive_link("sculpture"),
            ); ?>?on_promotion=1" class="btn-view-promo">
                View All Offers
            </a>
        </div>

    </section>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

// ========================================
// EXHIBITIONS HELPER FUNCTIONS
// ========================================

/**
 * Get exhibition status based on dates
 * 
 * @param int|null $post_id Exhibition post ID
 * @return string 'current', 'upcoming', or 'past'
 */
function exhibition_get_status($post_id = null) {
    $start_date = get_field('start_date', $post_id);
    $end_date = get_field('end_date', $post_id);
    
    if (!$start_date || !$end_date) {
        return 'upcoming';
    }
    
    $today = date('Ymd');
    
    if ($today >= $start_date && $today <= $end_date) {
        return 'current';
    } elseif ($today < $start_date) {
        return 'upcoming';
    } else {
        return 'past';
    }
}

/**
 * Get exhibition status label
 * 
 * @param string $status Status value
 * @return string Translated label
 */
function exhibition_get_status_label($status) {
    $labels = array(
        'current'  => __('Current', 'sculpture-theme'),
        'upcoming' => __('Upcoming', 'sculpture-theme'),
        'past'     => __('Past', 'sculpture-theme'),
    );
    
    return isset($labels[$status]) ? $labels[$status] : '';
}

/**
 * Get formatted date range for exhibition
 * 
 * @param int|null $post_id Exhibition post ID
 * @return string Formatted date range
 */
function exhibition_get_date_range($post_id = null) {
    $start_date = get_field('start_date', $post_id);
    $end_date = get_field('end_date', $post_id);
    
    if (!$start_date || !$end_date) {
        return '';
    }
    
    // Convert from Ymd to readable format
    $start = DateTime::createFromFormat('Ymd', $start_date);
    $end = DateTime::createFromFormat('Ymd', $end_date);
    
    if (!$start || !$end) {
        return '';
    }
    
    // Format: "15 Jan - 28 Feb 2025"
    if ($start->format('Y') === $end->format('Y')) {
        if ($start->format('m') === $end->format('m')) {
            // Same month: "15-28 Jan 2025"
            return $start->format('j') . '–' . $end->format('j M Y');
        } else {
            // Different months, same year: "15 Jan - 28 Feb 2025"
            return $start->format('j M') . ' – ' . $end->format('j M Y');
        }
    } else {
        // Different years: "15 Jan 2025 - 28 Feb 2026"
        return $start->format('j M Y') . ' – ' . $end->format('j M Y');
    }
}

/**
 * Check if exhibition is currently active
 * 
 * @param int|null $post_id Exhibition post ID
 * @return bool
 */
function exhibition_is_current($post_id = null) {
    return exhibition_get_status($post_id) === 'current';
}

/**
 * Get exhibitions grouped by status
 * 
 * @param int $posts_per_status Posts per status group (-1 for all)
 * @return array Array with 'current', 'upcoming', 'past' keys
 */
function exhibition_get_grouped_by_status($posts_per_status = -1) {
    $args = array(
        'post_type'      => 'exhibition',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    );
    
    $exhibitions = get_posts($args);
    
    $grouped = array(
        'current'  => array(),
        'upcoming' => array(),
        'past'     => array(),
    );
    
    foreach ($exhibitions as $exhibition) {
        $status = exhibition_get_status($exhibition->ID);
        $grouped[$status][] = $exhibition;
    }
    
    return $grouped;
}


add_shortcode("promo_sculptures", "sculpture_promo_shortcode");

add_filter("body_class", "sculpture_body_classes");
add_shortcode("featured_sculptures", "sculpture_featured_shortcode");
