<?php
/**
 * Archive Sculpture Template - Gallery with Filters
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); 

// Get filter parameters
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
$availability_filter = isset($_GET['availability']) ? sanitize_text_field($_GET['availability']) : '';
$materials_filter = isset($_GET['materials']) ? sanitize_text_field($_GET['materials']) : '';

// Build query args
$query_args = array(
    'post_type'      => 'sculpture',
    'posts_per_page' => 12,
    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
);

// Sorting
switch ($orderby) {
    case 'price_low':
        $query_args['meta_key'] = 'price';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'ASC';
        break;
    case 'price_high':
        $query_args['meta_key'] = 'price';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        break;
    case 'year':
        $query_args['meta_key'] = 'year';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        break;
    case 'title':
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
        break;
    default:
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
}

// Filters
$meta_query = array('relation' => 'AND');

if ($availability_filter) {
    $meta_query[] = array(
        'key'     => 'availability',
        'value'   => $availability_filter,
        'compare' => '=',
    );
}

if ($materials_filter) {
    $meta_query[] = array(
        'key'     => 'materials',
        'value'   => $materials_filter,
        'compare' => 'LIKE',
    );
}

if (count($meta_query) > 1) {
    $query_args['meta_query'] = $meta_query;
}

$sculptures = new WP_Query($query_args);

// Get unique materials for filter dropdown
$all_materials = array();
$materials_query = new WP_Query(array(
    'post_type' => 'sculpture',
    'posts_per_page' => -1,
    'fields' => 'ids',
));
if ($materials_query->have_posts()) {
    while ($materials_query->have_posts()) {
        $materials_query->the_post();
        $mat = get_field('materials');
        if ($mat && !in_array($mat, $all_materials)) {
            $all_materials[] = $mat;
        }
    }
    wp_reset_postdata();
}
sort($all_materials);
?>

<div class="sculpture-archive">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <h1 class="archive-title">Sculpture Gallery</h1>
        <p class="archive-subtitle">Explore our collection of original artworks</p>
    </header>

    <!-- Filters & Sorting -->
    <div class="sculpture-filters">
        <form method="GET" action="" class="filters-form">
            
            <div class="filters-row">
                
                <!-- Sort By -->
                <div class="filter-group">
                    <label for="orderby" class="filter-label">Sort By:</label>
                    <select name="orderby" id="orderby" class="filter-select">
                        <option value="date" <?php selected($orderby, 'date'); ?>>Latest</option>
                        <option value="title" <?php selected($orderby, 'title'); ?>>Title (A-Z)</option>
                        <option value="year" <?php selected($orderby, 'year'); ?>>Year (Newest)</option>
                        <option value="price_low" <?php selected($orderby, 'price_low'); ?>>Price (Low to High)</option>
                        <option value="price_high" <?php selected($orderby, 'price_high'); ?>>Price (High to Low)</option>
                    </select>
                </div>
                
                <!-- Availability Filter -->
                <div class="filter-group">
                    <label for="availability" class="filter-label">Availability:</label>
                    <select name="availability" id="availability" class="filter-select">
                        <option value="">All</option>
                        <option value="Available" <?php selected($availability_filter, 'Available'); ?>>Available</option>
                        <option value="Sold" <?php selected($availability_filter, 'Sold'); ?>>Sold</option>
                        <option value="Reserved" <?php selected($availability_filter, 'Reserved'); ?>>Reserved</option>
                    </select>
                </div>
                
                <!-- Materials Filter -->
                <?php if (!empty($all_materials)): ?>
                <div class="filter-group">
                    <label for="materials" class="filter-label">Materials:</label>
                    <select name="materials" id="materials" class="filter-select">
                        <option value="">All Materials</option>
                        <?php foreach ($all_materials as $material): ?>
                            <option value="<?php echo esc_attr($material); ?>" <?php selected($materials_filter, $material); ?>>
                                <?php echo esc_html($material); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <!-- Buttons -->
                <div class="filter-group filter-buttons">
                    <button type="submit" class="btn-filter">Apply Filters</button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-reset">Reset</a>
                </div>
                
            </div>
            
        </form>
    </div>

    <!-- Results Count -->
    <?php if ($sculptures->have_posts()): ?>
        <div class="results-info">
            <p>Showing <?php echo $sculptures->post_count; ?> of <?php echo $sculptures->found_posts; ?> sculptures</p>
        </div>
    <?php endif; ?>

    <!-- Sculptures Grid -->
    <?php if ($sculptures->have_posts()): ?>
        
        <div class="sculptures-grid">
            
            <?php 
            while ($sculptures->have_posts()): 
                $sculptures->the_post();
                get_template_part('template-parts/sculpture/card');
            endwhile; 
            ?>
            
        </div>
        
        <!-- Pagination -->
        <?php
        echo paginate_links(array(
            'total'     => $sculptures->max_num_pages,
            'current'   => max(1, get_query_var('paged')),
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'type'      => 'list',
        ));
        ?>
        
    <?php else: ?>
        
        <div class="no-sculptures">
            <p>No sculptures found with the selected filters.</p>
            <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-reset">Clear Filters</a>
        </div>
        
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
    
</div>

<?php get_footer(); ?>