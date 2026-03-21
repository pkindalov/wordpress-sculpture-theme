<?php
/**
 * Archive Template: Sculpture Gallery
 *
 * Displays filterable grid of sculptures with modern UI
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if (!defined("ABSPATH")) {
    exit();
}

get_header();

// ========================================
// 1. GET FILTER PARAMETERS
// ========================================
$filters = [
    "orderby" => isset($_GET["orderby"])
        ? sanitize_text_field($_GET["orderby"])
        : "date",
    "availability" => isset($_GET["availability"])
        ? sanitize_text_field($_GET["availability"])
        : "",
    "materials" => isset($_GET["materials"])
        ? sanitize_text_field($_GET["materials"])
        : "",
    "featured" => isset($_GET["featured"])
        ? sanitize_text_field($_GET["featured"])
        : "",
    "search" => isset($_GET["search_query"])
        ? sanitize_text_field($_GET["search_query"])
        : "",
    "price_min" =>
        isset($_GET["price_min"]) && $_GET["price_min"] !== ""
            ? intval($_GET["price_min"])
            : "",
    "price_max" =>
        isset($_GET["price_max"]) && $_GET["price_max"] !== ""
            ? intval($_GET["price_max"])
            : "",
    "year_min" =>
        isset($_GET["year_min"]) && $_GET["year_min"] !== ""
            ? intval($_GET["year_min"])
            : "",
    "year_max" =>
        isset($_GET["year_max"]) && $_GET["year_max"] !== ""
            ? intval($_GET["year_max"])
            : "",
    "on_promotion" => isset($_GET["on_promotion"])
        ? sanitize_text_field($_GET["on_promotion"])
        : "",
];

// ========================================
// 2. BUILD QUERY ARGUMENTS
// ========================================
$query_args = sculpture_build_query_args($filters);

// ========================================
// 3. EXECUTE MAIN QUERY
// ========================================
$sculptures = new WP_Query($query_args);

// ========================================
// 4. GET FILTER OPTIONS (for dropdowns/sliders)
// ========================================
$filter_data = sculpture_get_filter_data();
$next_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Next'] : buttons['en']['Следваща'];
$previous_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Previous'] : buttons['en']['Предишна'];
?>

<div class="sculpture-archive">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <h1 class="archive-title"><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['Sculpture Gallery'] : common_translations['en']['Галерия Със Скулптури']); ?></h1>
        <p class="archive-subtitle"><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['Explore our collection of original artworks'] : common_translations['en']['Разгледайте нашата колекция от оригинални произведения на изкуството']); ?></p>
    </header>

    <!-- Filters Component -->
    <?php get_template_part("template-parts/sculpture/filters", null, [
        "filters" => $filters,
        "filter_data" => $filter_data,
    ]); ?>

    <!-- Results Info -->
    <?php if ($sculptures->have_posts()): ?>
        <div class="results-info-modern">
            <span class="results-count"><?php echo esc_html(
                $sculptures->found_posts,
            ); ?></span>
            <span class="results-text"><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['sculptures found'] : common_translations['en']['намерени скулптури']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Sculptures Grid -->
    <?php if ($sculptures->have_posts()): ?>
        
        <div class="sculptures-grid">
            <?php while ($sculptures->have_posts()):
                $sculptures->the_post();
                get_template_part("template-parts/sculpture/card");
            endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($sculptures->max_num_pages > 1): ?>
            <div class="pagination">
                <?php echo paginate_links([
                    "total" => $sculptures->max_num_pages,
                    "current" => max(1, get_query_var("paged")),
                    "prev_text" => "← " . $previous_btn_label,
                    "next_text" => $next_btn_label . " →",
                ]); ?>
            </div>
        <?php endif; ?>
        
    <?php else: ?>
        
        <!-- No Results -->
        <div class="no-sculptures-modern">
            <svg width="80" height="80" fill="currentColor" viewBox="0 0 16 16">
                <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
            <h3><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['No sculptures found'] : common_translations['en']['Не са намерени скулптури']); ?></h3>
            <p><?php echo (get_current_active_language() === 'bg' ? common_translations['bg']['Try adjusting your filters to see more results'] : common_translations['en']['Опитайте да коригирате филтрите си, за да видите повече резултати']); ?></p>
            <a href="<?php echo esc_url(
                get_post_type_archive_link("sculpture"),
            ); ?>" class="btn-clear-filters">
                <?php echo (get_current_active_language() === 'bg' ? buttons['bg']['Clear All'] : buttons['en']['Премахни Филтри']); ?>
            </a>
        </div>
        
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
    
    <!-- Back to Home Button -->
    <div class="archive-footer-nav">
        <a href="<?php echo esc_url(home_url("/")); ?>" class="btn-back-home">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>
            <?php echo (get_current_active_language() === 'bg' ? buttons['bg']['Back to Home'] : buttons['en']['Към Начална Страница']); ?>
        </a>
    </div>
    
</div>

<?php
// Include footer component
get_template_part("template-parts/global/footer-cta");

get_footer();

// ========================================
// HELPER FUNCTIONS
// ========================================

/**
 * Build WP_Query arguments from filters
 *
 * @param array $filters Filter parameters
 * @return array Query arguments
 */
function sculpture_build_query_args($filters)
{
    $args = [
        "post_type" => "sculpture",
        "posts_per_page" => 12,
        "paged" => get_query_var("paged") ? get_query_var("paged") : 1,
    ];

    // Sorting
    switch ($filters["orderby"]) {
        case "price_low":
            $args["meta_key"] = "price";
            $args["orderby"] = "meta_value_num";
            $args["order"] = "ASC";
            break;
        case "price_high":
            $args["meta_key"] = "price";
            $args["orderby"] = "meta_value_num";
            $args["order"] = "DESC";
            break;
        case "year":
            $args["meta_key"] = "year";
            $args["orderby"] = "meta_value_num";
            $args["order"] = "DESC";
            break;
        case "title":
            $args["orderby"] = "title";
            $args["order"] = "ASC";
            break;
        default:
            $args["orderby"] = "date";
            $args["order"] = "DESC";
    }

    // On Promotion filter
    if (!empty($filters["on_promotion"])) {
        $today = date("Ymd");
        $meta_query[] = [
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
        ];
    }

    // Build meta query
    $meta_query = ["relation" => "AND"];

    // Availability filter
    if ($filters["availability"]) {
        $meta_query[] = [
            "key" => "availability",
            "value" => $filters["availability"],
            "compare" => "=",
        ];
    }

    // Materials filter
    if ($filters["materials"]) {
        $meta_query[] = [
            "key" => "materials",
            "value" => $filters["materials"],
            "compare" => "LIKE",
        ];
    }

    // Featured filter
    if ($filters["featured"] === "yes") {
        $meta_query[] = [
            "key" => "featured",
            "value" => "1",
            "compare" => "=",
        ];
    }

    // On Promotion filter
    if (!empty($filters["on_promotion"])) {
        $today = date("Ymd");
        $meta_query[] = [
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
        ];
    }

    // Price range filter
    if ($filters["price_min"] !== "" || $filters["price_max"] !== "") {
        $price_query = ["key" => "price", "type" => "NUMERIC"];

        if ($filters["price_min"] !== "" && $filters["price_max"] !== "") {
            $price_query["value"] = [
                $filters["price_min"],
                $filters["price_max"],
            ];
            $price_query["compare"] = "BETWEEN";
        } elseif ($filters["price_min"] !== "") {
            $price_query["value"] = $filters["price_min"];
            $price_query["compare"] = ">=";
        } else {
            $price_query["value"] = $filters["price_max"];
            $price_query["compare"] = "<=";
        }

        $meta_query[] = $price_query;
    }

    // Year range filter
    if ($filters["year_min"] !== "" || $filters["year_max"] !== "") {
        $year_query = ["key" => "year", "type" => "NUMERIC"];

        if ($filters["year_min"] !== "" && $filters["year_max"] !== "") {
            $year_query["value"] = [$filters["year_min"], $filters["year_max"]];
            $year_query["compare"] = "BETWEEN";
        } elseif ($filters["year_min"] !== "") {
            $year_query["value"] = $filters["year_min"];
            $year_query["compare"] = ">=";
        } else {
            $year_query["value"] = $filters["year_max"];
            $year_query["compare"] = "<=";
        }

        $meta_query[] = $year_query;
    }

    if (count($meta_query) > 1) {
        $args["meta_query"] = $meta_query;
    }

    // Title search
    if ($filters["search"]) {
        global $sculpture_search_term;
        $sculpture_search_term = $filters["search"];
        add_filter("posts_where", "sculpture_search_where_filter", 10, 2);
    }

    return $args;
}

/**
 * Get all filter data (materials, price range, year range)
 * Optimized: Single query instead of 3 separate queries
 *
 * @return array Filter data
 */
function sculpture_get_filter_data()
{
    static $cache = null;

    if ($cache !== null) {
        return $cache;
    }

    $data = [
        "materials" => [],
        "min_price" => 0,
        "max_price" => 200,
        "min_year" => date("Y") - 50,
        "max_year" => date("Y"),
    ];

    // Single optimized query
    $sculptures = new WP_Query([
        "post_type" => "sculpture",
        "posts_per_page" => -1,
        "fields" => "ids",
        "no_found_rows" => true,
    ]);

    if ($sculptures->have_posts()) {
        while ($sculptures->have_posts()) {
            $sculptures->the_post();

            // Materials
            // $material = get_field('materials');
            // if ($material && !in_array($material, $data['materials'])) {
            //     $data['materials'][] = $material;
            // }

            // Price range
            $price = get_field("price");
            if ($price) {
                if ($data["min_price"] === 0) {
                    $data["min_price"] = $price;
                }
                $data["min_price"] = min($data["min_price"], (int) $price);
                $data["max_price"] = max($data["max_price"], (int) $price);
            }

            // Year range
            $year = get_field("year");
            if ($year) {
                $data["min_year"] = min($data["min_year"], (int) $year);
                $data["max_year"] = max($data["max_year"], (int) $year);
            }
        }
        wp_reset_postdata();
    }

    // sort($data['materials']);

    $cache = $data;
    return $data;
}

/**
 * Custom search filter - searches in post title only
 *
 * @param string $where SQL WHERE clause
 * @param WP_Query $query Query object
 * @return string Modified WHERE clause
 */
function sculpture_search_where_filter($where, $query)
{
    global $wpdb, $sculpture_search_term;

    if (
        !empty($sculpture_search_term) &&
        $query->get("post_type") === "sculpture"
    ) {
        $like = "%" . $wpdb->esc_like($sculpture_search_term) . "%";
        $where .= $wpdb->prepare(
            " AND {$wpdb->posts}.post_title LIKE %s",
            $like,
        );

        // Reset after use
        $sculpture_search_term = "";
    }

    return $where;
}

/**
 * Get dynamic choices from ACF select field
 *
 * @param string $field_name ACF field name
 * @return array Array of choices (value => label)
 */
function sculpture_get_acf_choices($field_name)
{
    static $cache = [];

    // Return cached if exists
    if (isset($cache[$field_name])) {
        return $cache[$field_name];
    }

    // Get one sculpture post to read field definition
    $posts = get_posts([
        "post_type" => "sculpture",
        "posts_per_page" => 1,
        "fields" => "ids",
    ]);

    if (empty($posts)) {
        return [];
    }

    // Get field object with all settings
    $field = get_field_object($field_name, $posts[0]);

    // Extract choices
    if ($field && isset($field["choices"]) && is_array($field["choices"])) {
        $cache[$field_name] = $field["choices"];
        return $field["choices"];
    }

    return [];
}
