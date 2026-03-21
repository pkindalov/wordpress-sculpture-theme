<?php
/**
 * Archive template for Publications
 * With tabs for filtering by type
 *
 * @package Sculpture_Theme
 */

get_header();

$paged = isset($_GET["pg"]) ? intval($_GET["pg"]) : 1;
$active_tab = isset($_GET["type"]) ? sanitize_text_field($_GET["type"]) : "all";
$per_page = 15; // 9 cards (3x3 grid)

$back_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Back to Home'] : buttons['en']['Към Начална Страница'];
$publications_label = get_current_active_language() === 'bg' ? common_translations['bg']['Publications'] : common_translations['en']['Публикации'];
$all_tab_label = get_current_active_language() === 'bg' ? common_translations['bg']['All'] : common_translations['en']['Всички'];
$written_by_me_label = get_current_active_language() === 'bg' ? common_translations['bg']['Written by me'] : common_translations['en']['Написани от мен'];
$written_from_me_label = get_current_active_language() === 'bg' ? common_translations['bg']['Written about me'] : common_translations['en']['Написани за мен'];
$previous_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Previous'] : buttons['en']['Предишна'];
$next_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Next'] : buttons['en']['Следваща'];
$no_publications_found_label = get_current_active_language() === 'bg' ? common_translations['bg']['No publications found'] : common_translations['en']['Не са намерени публикации'];

// Build query args
$args = [
    "post_type" => "publication",
    "posts_per_page" => $per_page,
    "paged" => $paged,
    "post_status" => "publish",
    "orderby" => "date",
    "order" => "DESC",
];

// Filter by type if not "all"
if ($active_tab !== "all") {
    $args["meta_query"] = [
        [
            "key" => "article_type",
            "value" => $active_tab,
            "compare" => "=",
        ],
    ];
}

$publications_query = new WP_Query($args);
?>

<div class="publications-archive-container">
    
    <header class="archive-header">
        <a href="<?php echo home_url("/"); ?>" class="back-to-home">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.5 15l-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php _e($back_btn_label, "sculpture-theme"); ?>
        </a>
        <h1 class="archive-title"><?php _e(
            $publications_label,
            "sculpture-theme",
        ); ?></h1>
    </header>
    
    <!-- TABS -->
    <nav class="publications-tabs">
        <a href="<?php echo remove_query_arg(["type", "pg"]); ?>" 
           class="tab <?php echo $active_tab === "all" ? "active" : ""; ?>">
            <?php _e($all_tab_label, "sculpture-theme"); ?>
        </a>
        <a href="<?php echo add_query_arg(
            "type",
            "by_me",
            remove_query_arg("pg"),
        ); ?>" 
           class="tab <?php echo $active_tab === "by_me" ? "active" : ""; ?>">
            <?php _e($written_by_me_label, "sculpture-theme"); ?>
        </a>
        <a href="<?php echo add_query_arg(
            "type",
            "about_me",
            remove_query_arg("pg"),
        ); ?>" 
           class="tab <?php echo $active_tab === "about_me"
               ? "active"
               : ""; ?>">
            <?php _e($written_from_me_label, "sculpture-theme"); ?>
        </a>
    </nav>
    
    <div class="publications-content">
        
        <?php if ($publications_query->have_posts()): ?>
        
            <div class="publications-grid">
                <?php
                while ($publications_query->have_posts()):
                    $publications_query->the_post();
                    get_template_part("template-parts/publication/card");
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($publications_query->max_num_pages > 1): ?>
            <nav class="publications-pagination">
                <div class="pagination-numbers">
                    
                    <?php if ($paged > 1): ?>
                        <a href="<?php echo remove_query_arg(
                            "pg",
                        ); ?>" class="pagination-nav">
                            ← <?php _e($previous_btn_label, "sculpture-theme"); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php for (
                        $i = 1;
                        $i <= $publications_query->max_num_pages;
                        $i++
                    ): ?>
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
                    
                    <?php if ($paged < $publications_query->max_num_pages): ?>
                        <a href="<?php echo add_query_arg(
                            "pg",
                            $paged + 1,
                        ); ?>" class="pagination-nav">
                            <?php _e($next_btn_label, "sculpture-theme"); ?> →
                        </a>
                    <?php endif; ?>
                    
                </div>
            </nav>
            <?php endif; ?>
        
        <?php else: ?>
        
            <div class="no-publications">
                <p><?php _e($no_publications_found_label, "sculpture-theme"); ?></p>
            </div>
        
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>
