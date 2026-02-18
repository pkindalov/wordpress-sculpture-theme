<?php
/**
 * Archive template for Exhibitions
 * Sorted in PHP by status
 * 
 * @package Sculpture_Theme
 */

get_header();

$paged = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
$per_page = 5;

// Get ALL exhibitions first
$all_args = array(
    'post_type'      => 'exhibition',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

$all_query = new WP_Query($all_args);

// Sort into groups
$grouped = array(
    'current'  => array(),
    'upcoming' => array(),
    'past'     => array(),
);

if ($all_query->have_posts()) {
    while ($all_query->have_posts()) {
        $all_query->the_post();
        $status = exhibition_get_status(get_the_ID());
        $start_date = get_field('start_date', get_the_ID());
        
        $grouped[$status][] = array(
            'post' => get_post(),
            'start_date' => $start_date
        );
    }
    wp_reset_postdata();
}

// Sort each group
// Current & Past: newest first (DESC)
usort($grouped['current'], function($a, $b) {
    return strcmp($b['start_date'], $a['start_date']);
});

usort($grouped['past'], function($a, $b) {
    return strcmp($b['start_date'], $a['start_date']);
});

// Upcoming: closest first (ASC)
usort($grouped['upcoming'], function($a, $b) {
    return strcmp($a['start_date'], $b['start_date']);
});

// Merge into single sorted array
$sorted_exhibitions = array();
foreach ($grouped['current'] as $item) {
    $sorted_exhibitions[] = $item['post'];
}
foreach ($grouped['upcoming'] as $item) {
    $sorted_exhibitions[] = $item['post'];
}
foreach ($grouped['past'] as $item) {
    $sorted_exhibitions[] = $item['post'];
}

// Pagination calculations
$total_posts = count($sorted_exhibitions);
$max_pages = ceil($total_posts / $per_page);
$offset = ($paged - 1) * $per_page;
$paged_exhibitions = array_slice($sorted_exhibitions, $offset, $per_page);
?>

<div class="exhibitions-archive-container">
    
    <header class="archive-header">
        <h1 class="archive-title"><?php _e('Exhibitions', 'sculpture-theme'); ?></h1>
    </header>
    
    <div class="exhibitions-timeline">
        
        <?php if (!empty($paged_exhibitions)): ?>
        
            <div class="exhibition-timeline-list">
                <?php 
                $counter = 0;
                foreach ($paged_exhibitions as $post):
                    setup_postdata($post);
                    $counter++;
                    $side_class = ($counter % 2 === 1) ? 'timeline-left' : 'timeline-right';
                    set_query_var('timeline_side', $side_class);
                    get_template_part('template-parts/exhibition/timeline-item');
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($max_pages > 1): ?>
            <nav class="exhibitions-pagination">
                <div class="pagination-numbers">
                    
                    <?php if ($paged > 1): ?>
                        <a href="<?php echo remove_query_arg('pg'); ?>" class="pagination-nav">
                            ← <?php _e('Previous', 'sculpture-theme'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $max_pages; $i++): ?>
                        <?php if ($i === $paged): ?>
                            <span class="page-number current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo ($i === 1) ? remove_query_arg('pg') : add_query_arg('pg', $i); ?>" class="page-number">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($paged < $max_pages): ?>
                        <a href="<?php echo add_query_arg('pg', $paged + 1); ?>" class="pagination-nav">
                            <?php _e('Next', 'sculpture-theme'); ?> →
                        </a>
                    <?php endif; ?>
                    
                </div>
            </nav>
            <?php endif; ?>
        
        <?php else: ?>
        
            <div class="no-exhibitions">
                <p><?php _e('No exhibitions found.', 'sculpture-theme'); ?></p>
            </div>
        
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>