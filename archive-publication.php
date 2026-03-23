<?php
/**
 * Archive template for Publications
 * With tabs for filtering by type
 *
 * @package Sculpture_Theme
 */

get_header();

$paged = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
$active_tab = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all';
$per_page = 15; // 15 cards (3x5 grid)

// Get translated labels
$back_btn_label = sculpture_translate('Back to Home', 'buttons');
$publications_label = sculpture_translate('Publications', 'common');
$all_tab_label = sculpture_translate('All', 'common');
$written_by_me_label = sculpture_translate('Written by me', 'common');
$written_from_me_label = sculpture_translate('Written about me', 'common');
$previous_btn_label = sculpture_translate('Previous', 'buttons');
$next_btn_label = sculpture_translate('Next', 'buttons');
$no_publications_found_label = sculpture_translate('No publications found', 'errors');

// Build query args
$args = [
    'post_type' => 'publication',
    'posts_per_page' => $per_page,
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
];

// Filter by type if not "all"
if ($active_tab !== 'all') {
    $args['meta_query'] = [
        [
            'key' => 'article_type',
            'value' => $active_tab,
            'compare' => '=',
        ],
    ];
}

$publications_query = new WP_Query($args);
?>

<div class="publications-archive-container">
    
    <header class="archive-header">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-home">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.5 15l-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php echo $back_btn_label; ?>
        </a>
        <h1 class="archive-title"><?php echo $publications_label; ?></h1>
    </header>
    
    <!-- TABS -->
    <nav class="publications-tabs">
        <a href="<?php echo esc_url(remove_query_arg(['type', 'pg'])); ?>" 
           class="tab <?php echo $active_tab === 'all' ? 'active' : ''; ?>">
            <?php echo $all_tab_label; ?>
        </a>
        <a href="<?php echo esc_url(add_query_arg('type', 'by_me', remove_query_arg('pg'))); ?>" 
           class="tab <?php echo $active_tab === 'by_me' ? 'active' : ''; ?>">
            <?php echo $written_by_me_label; ?>
        </a>
        <a href="<?php echo esc_url(add_query_arg('type', 'about_me', remove_query_arg('pg'))); ?>" 
           class="tab <?php echo $active_tab === 'about_me' ? 'active' : ''; ?>">
            <?php echo $written_from_me_label; ?>
        </a>
    </nav>
    
    <div class="publications-content">
        
        <?php if ($publications_query->have_posts()): ?>
        
            <div class="publications-grid">
                <?php
                while ($publications_query->have_posts()):
                    $publications_query->the_post();
                    get_template_part('template-parts/publication/card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($publications_query->max_num_pages > 1): ?>
            <nav class="publications-pagination">
                <div class="pagination-numbers">
                    
                    <?php if ($paged > 1): ?>
                        <a href="<?php echo esc_url(remove_query_arg('pg')); ?>" class="pagination-nav">
                            ← <?php echo $previous_btn_label; ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $publications_query->max_num_pages; $i++): ?>
                        <?php if ($i === $paged): ?>
                            <span class="page-number current"><?php echo esc_html($i); ?></span>
                        <?php else: ?>
                            <a href="<?php echo esc_url($i === 1 ? remove_query_arg('pg') : add_query_arg('pg', $i)); ?>" class="page-number">
                                <?php echo esc_html($i); ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($paged < $publications_query->max_num_pages): ?>
                        <a href="<?php echo esc_url(add_query_arg('pg', $paged + 1)); ?>" class="pagination-nav">
                            <?php echo $next_btn_label; ?> →
                        </a>
                    <?php endif; ?>
                    
                </div>
            </nav>
            <?php endif; ?>
        
        <?php else: ?>
        
            <div class="no-publications">
                <p><?php echo $no_publications_found_label; ?></p>
            </div>
        
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>