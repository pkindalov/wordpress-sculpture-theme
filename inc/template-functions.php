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
function exhibition_get_status($post_id = null)
{
    $start_date = get_field("start_date", $post_id);
    $end_date = get_field("end_date", $post_id);

    if (!$start_date || !$end_date) {
        return "upcoming";
    }

    $today = date("Ymd");

    if ($today >= $start_date && $today <= $end_date) {
        return "current";
    } elseif ($today < $start_date) {
        return "upcoming";
    } else {
        return "past";
    }
}

/**
 * Get exhibition status label
 *
 * @param string $status Status value
 * @return string Translated label
 */
function exhibition_get_status_label($status)
{
    $labels = [
        "current" => __("Current", "sculpture-theme"),
        "upcoming" => __("Upcoming", "sculpture-theme"),
        "past" => __("Past", "sculpture-theme"),
    ];

    return isset($labels[$status]) ? $labels[$status] : "";
}

/**
 * Get formatted date range for exhibition
 *
 * @param int|null $post_id Exhibition post ID
 * @return string Formatted date range
 */
function exhibition_get_date_range($post_id = null)
{
    $start_date = get_field("start_date", $post_id);
    $end_date = get_field("end_date", $post_id);

    if (!$start_date || !$end_date) {
        return "";
    }

    // Convert from Ymd to readable format
    $start = DateTime::createFromFormat("Ymd", $start_date);
    $end = DateTime::createFromFormat("Ymd", $end_date);

    if (!$start || !$end) {
        return "";
    }

    // Format: "15 Jan - 28 Feb 2025"
    if ($start->format("Y") === $end->format("Y")) {
        if ($start->format("m") === $end->format("m")) {
            // Same month: "15-28 Jan 2025"
            return $start->format("j") . "–" . $end->format("j M Y");
        } else {
            // Different months, same year: "15 Jan - 28 Feb 2025"
            return $start->format("j M") . " – " . $end->format("j M Y");
        }
    } else {
        // Different years: "15 Jan 2025 - 28 Feb 2026"
        return $start->format("j M Y") . " – " . $end->format("j M Y");
    }
}

/**
 * Check if exhibition is currently active
 *
 * @param int|null $post_id Exhibition post ID
 * @return bool
 */
function exhibition_is_current($post_id = null)
{
    return exhibition_get_status($post_id) === "current";
}

/**
 * Get exhibitions grouped by status
 *
 * @param int $posts_per_status Posts per status group (-1 for all)
 * @return array Array with 'current', 'upcoming', 'past' keys
 */
function exhibition_get_grouped_by_status($posts_per_status = -1)
{
    $args = [
        "post_type" => "exhibition",
        "posts_per_page" => -1,
        "post_status" => "publish",
        "meta_key" => "start_date",
        "orderby" => "meta_value",
        "order" => "ASC",
    ];

    $exhibitions = get_posts($args);

    $grouped = [
        "current" => [],
        "upcoming" => [],
        "past" => [],
    ];

    foreach ($exhibitions as $exhibition) {
        $status = exhibition_get_status($exhibition->ID);
        $grouped[$status][] = $exhibition;
    }

    return $grouped;
}

// ========================================
// EXHIBITIONS SHORTCODE FOR HOMEPAGE
// ========================================

/**
 * Exhibitions Timeline Shortcode
 *
 * Display recent exhibitions on homepage
 * Usage: [exhibitions_timeline count="3"]
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
/**
 * Exhibitions Timeline Shortcode
 *
 * Display recent exhibitions on homepage
 * Usage: [exhibitions_timeline count="4"]
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_exhibitions_timeline_shortcode($atts)
{
    $atts = shortcode_atts(
        [
            "count" => 4,
        ],
        $atts,
        "exhibitions_timeline",
    );

    // Get ALL exhibitions
    $all_args = [
        "post_type" => "exhibition",
        "posts_per_page" => -1,
        "post_status" => "publish",
    ];

    $all_query = new WP_Query($all_args);

    // Sort by status
    $grouped = [
        "current" => [],
        "upcoming" => [],
        "past" => [],
    ];

    if ($all_query->have_posts()) {
        while ($all_query->have_posts()) {
            $all_query->the_post();
            $status = exhibition_get_status(get_the_ID());
            $start_date = get_field("start_date", get_the_ID());

            $grouped[$status][] = [
                "post" => get_post(),
                "start_date" => $start_date,
            ];
        }
        wp_reset_postdata();
    }

    // Sort each group
    usort($grouped["current"], function ($a, $b) {
        return strcmp($b["start_date"], $a["start_date"]);
    });

    usort($grouped["past"], function ($a, $b) {
        return strcmp($b["start_date"], $a["start_date"]);
    });

    usort($grouped["upcoming"], function ($a, $b) {
        return strcmp($a["start_date"], $b["start_date"]);
    });

    // Merge: Current → Upcoming → Past
    $sorted = [];
    foreach ($grouped["current"] as $item) {
        $sorted[] = $item["post"];
    }
    foreach ($grouped["upcoming"] as $item) {
        $sorted[] = $item["post"];
    }
    foreach ($grouped["past"] as $item) {
        $sorted[] = $item["post"];
    }

    // Limit to count
    $limited = array_slice($sorted, 0, intval($atts["count"]));

    if (empty($limited)) {
        return "";
    }

    // Output
    ob_start();

    global $post;
    ?>
    
    <div class="homepage-exhibitions-section">
        <div class="section-header">
            <h2 class="section-title">Exhibitions</h2>
            <a href="<?php echo get_post_type_archive_link(
                "exhibition",
            ); ?>" class="view-all-link">
                View All Exhibitions →
            </a>
        </div>
        
        <div class="exhibition-timeline-list homepage-timeline">
            <?php
            $counter = 0;

            foreach ($limited as $post):
                setup_postdata($post);
                $counter++;
                $side_class =
                    $counter % 2 === 1 ? "timeline-left" : "timeline-right";
                set_query_var("timeline_side", $side_class);
                get_template_part("template-parts/exhibition/timeline-item");
            endforeach;

            wp_reset_postdata();
            ?>
        </div>
        
        <div class="section-footer">
            <a href="<?php echo get_post_type_archive_link(
                "exhibition",
            ); ?>" class="view-all-button">
                View All Exhibitions
            </a>
        </div>
    </div>
    
    <?php return ob_get_clean();
}

// ========================================
// PUBLICATIONS HELPER FUNCTIONS
// ========================================

/**
 * Get publication type label
 * 
 * @param string $type Type value ('by_me' or 'about_me')
 * @return string Label
 */
function publication_get_type_label($type) {
    $labels = array(
        'by_me'    => __('Written by me', 'sculpture-theme'),
        'about_me' => __('Written about me', 'sculpture-theme'),
    );
    
    return isset($labels[$type]) ? $labels[$type] : '';
}

/**
 * Get formatted publication date
 * 
 * @param int|null $post_id Post ID
 * @return string Formatted date
 */
function publication_get_date($post_id = null) {
    $date = get_field('publication_date', $post_id);
    
    if (!$date) {
        return '';
    }
    
    // Convert from Ymd to readable format
    $date_obj = DateTime::createFromFormat('Ymd', $date);
    
    if (!$date_obj) {
        return '';
    }
    
    return $date_obj->format('d.m.Y');
}

/**
 * Get publication meta string
 * 
 * @param int|null $post_id Post ID
 * @return string Meta string (Publication, Date, Author if exists)
 */
function publication_get_meta($post_id = null) {
    $publication = get_field('publication', $post_id);
    $date = publication_get_date($post_id);
    $author = get_field('author', $post_id);
    
    $meta_parts = array();
    
    if ($publication) {
        $meta_parts[] = $publication;
    }
    
    if ($date) {
        $meta_parts[] = $date;
    }
    
    if ($author) {
        $meta_parts[] = __('Author:', 'sculpture-theme') . ' ' . $author;
    }
    
    return implode(' • ', $meta_parts);
}


/**
 * Publications Shortcode
 * 
 * Display recent publications on homepage (grouped by type)
 * Usage: [publications_showcase by_me="3" about_me="3"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function sculpture_publications_showcase_shortcode($atts) {
    
    $atts = shortcode_atts(array(
        'by_me'    => 3,
        'about_me' => 3,
    ), $atts, 'publications_showcase');
    
    // Get "By Me" publications
    $by_me_args = array(
        'post_type'      => 'publication',
        'posts_per_page' => intval($atts['by_me']),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'article_type',
                'value'   => 'by_me',
                'compare' => '='
            )
        )
    );
    
    $by_me_posts = new WP_Query($by_me_args);
    
    // Get "About Me" publications
    $about_me_args = array(
        'post_type'      => 'publication',
        'posts_per_page' => intval($atts['about_me']),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'article_type',
                'value'   => 'about_me',
                'compare' => '='
            )
        )
    );
    
    $about_me_posts = new WP_Query($about_me_args);
    
    // Check if we have any posts
    if (!$by_me_posts->have_posts() && !$about_me_posts->have_posts()) {
        return '';
    }
    
    // Output
    ob_start();
    ?>
    
    <div class="homepage-publications-section">
        <div class="section-header">
            <h2 class="section-title">Publications</h2>
            <a href="<?php echo get_post_type_archive_link('publication'); ?>" class="view-all-link">
                View All Publications →
            </a>
        </div>
        
        <?php if ($by_me_posts->have_posts()): ?>
        <!-- Written by Me Section -->
        <div class="publication-group">
            <h3 class="group-title">Written by me</h3>
            <div class="publications-grid homepage-publications-grid">
                <?php 
                while ($by_me_posts->have_posts()):
                    $by_me_posts->the_post();
                    get_template_part('template-parts/publication/card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($about_me_posts->have_posts()): ?>
        <!-- Written about Me Section -->
        <div class="publication-group">
            <h3 class="group-title">Written about me</h3>
            <div class="publications-grid homepage-publications-grid">
                <?php 
                while ($about_me_posts->have_posts()):
                    $about_me_posts->the_post();
                    get_template_part('template-parts/publication/card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="section-footer">
            <a href="<?php echo get_post_type_archive_link('publication'); ?>" class="view-all-button">
                View All Publications
            </a>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}



add_shortcode("promo_sculptures", "sculpture_promo_shortcode");

add_filter("body_class", "sculpture_body_classes");
add_shortcode("featured_sculptures", "sculpture_featured_shortcode");
add_shortcode(
    "exhibitions_timeline",
    "sculpture_exhibitions_timeline_shortcode",
);
add_shortcode('publications_showcase', 'sculpture_publications_showcase_shortcode');
