<?php
/**
 * Archive template for Exhibitions
 * Sorted in PHP by status
 *
 * @package Sculpture_Theme
 */

get_header();

$paged = isset($_GET["pg"]) ? intval($_GET["pg"]) : 1;
$per_page = 5;

// Get ALL exhibitions first
$all_args = [
    "post_type" => "exhibition",
    "posts_per_page" => -1,
    "post_status" => "publish",
];

$all_query = new WP_Query($all_args);

// Sort into groups
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
// Current & Past: newest first (DESC)
usort($grouped["current"], function ($a, $b) {
    return strcmp($b["start_date"], $a["start_date"]);
});

usort($grouped["past"], function ($a, $b) {
    return strcmp($b["start_date"], $a["start_date"]);
});

// Upcoming: closest first (ASC)
usort($grouped["upcoming"], function ($a, $b) {
    return strcmp($a["start_date"], $b["start_date"]);
});

// Merge into single sorted array
$sorted_exhibitions = [];
foreach ($grouped["current"] as $item) {
    $sorted_exhibitions[] = $item["post"];
}
foreach ($grouped["upcoming"] as $item) {
    $sorted_exhibitions[] = $item["post"];
}
foreach ($grouped["past"] as $item) {
    $sorted_exhibitions[] = $item["post"];
}

// Pagination calculations
$total_posts = count($sorted_exhibitions);
$max_pages = ceil($total_posts / $per_page);
$offset = ($paged - 1) * $per_page;
$paged_exhibitions = array_slice($sorted_exhibitions, $offset, $per_page);

$back_button_label = get_current_active_language() === "bg" ? buttons['bg']['Back to Home']  : buttons['en']['Към Начална Страница'];
$prev_button_label = get_current_active_language() === "bg" ? buttons['bg']['Previous']  : buttons['en']['Предишна'];
$next_button_label = get_current_active_language() === "bg" ? buttons['bg']['Next']  : buttons['en']['Следваща'];
$exhibitions_heading = get_current_active_language() === "bg" ? common_translations['bg']['Exhibitions']  : common_translations['en']['Изложби'];
$no_exhibitions_found_msg = get_current_active_language() === "bg" ? common_translations['bg']['No exhibitions found.'] : common_translations['en']['No exhibitions found.'];
?>

<div class="exhibitions-archive-container">
    
    <header class="archive-header">
        <a href="<?php echo home_url("/"); ?>" class="back-to-home">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.5 15l-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php _e($back_button_label, "sculpture-theme"); ?>
        </a>
        <h1 class="archive-title"><?php _e(
            $exhibitions_heading,
            "sculpture-theme",
        ); ?></h1>
    </header>
    
    <div class="exhibitions-timeline">
        
        <?php if (!empty($paged_exhibitions)): ?>
        
            <div class="exhibition-timeline-list">
                <?php
                $counter = 0;
                foreach ($paged_exhibitions as $post):
                    setup_postdata($post);
                    $counter++;
                    $side_class =
                        $counter % 2 === 1 ? "timeline-left" : "timeline-right";
                    set_query_var("timeline_side", $side_class);
                    get_template_part(
                        "template-parts/exhibition/timeline-item",
                    );
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($max_pages > 1): ?>
            <nav class="exhibitions-pagination">
                <div class="pagination-numbers">
                    
                    <?php if ($paged > 1): ?>
                        <a href="<?php echo remove_query_arg(
                            "pg",
                        ); ?>" class="pagination-nav">
                            ← <?php _e($prev_button_label, "sculpture-theme"); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $max_pages; $i++): ?>
                        <?php if ($i === $paged): ?>
                            <span class="page-number current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo $i === 1
                                ? remove_query_arg("pg")
                                : add_query_arg(
                                    "pg",
                                    $i,
                                ); ?>" class="page-number">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($paged < $max_pages): ?>
                        <a href="<?php echo add_query_arg(
                            "pg",
                            $paged + 1,
                        ); ?>" class="pagination-nav">
                            <?php _e($next_button_label, "sculpture-theme"); ?> →
                        </a>
                    <?php endif; ?>
                    
                </div>
            </nav>
            <?php endif; ?>
        
        <?php else: ?>
        
            <div class="no-exhibitions">
                <p><?php _e($no_exhibitions_found_msg, "sculpture-theme"); ?></p>
            </div>
        
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>
