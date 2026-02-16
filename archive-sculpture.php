<?php
/**
 * Archive Sculpture Template - Modern Filters UI
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
$featured_filter = isset($_GET['featured']) ? sanitize_text_field($_GET['featured']) : '';
$search = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
$price_min = isset($_GET['price_min']) ? intval($_GET['price_min']) : '';
$price_max = isset($_GET['price_max']) ? intval($_GET['price_max']) : '';
$year_min = isset($_GET['year_min']) ? intval($_GET['year_min']) : '';
$year_max = isset($_GET['year_max']) ? intval($_GET['year_max']) : '';

// Build query args
$query_args = array(
    'post_type'      => 'sculpture',
    'posts_per_page' => 12,
    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
);

// Search in title
if ($search) {
    global $sculpture_search_term;
    $sculpture_search_term = $search;
    
    add_filter('posts_where', 'sculpture_search_where_filter', 10, 2);
}

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

if ($featured_filter === 'yes') {
    $meta_query[] = array(
        'key'     => 'featured',
        'value'   => '1',
        'compare' => '=',
    );
}

if ($price_min !== '' || $price_max !== '') {
    $price_query = array('key' => 'price');
    
    if ($price_min !== '' && $price_max !== '') {
        $price_query['value'] = array($price_min, $price_max);
        $price_query['compare'] = 'BETWEEN';
        $price_query['type'] = 'NUMERIC';
    } elseif ($price_min !== '') {
        $price_query['value'] = $price_min;
        $price_query['compare'] = '>=';
        $price_query['type'] = 'NUMERIC';
    } elseif ($price_max !== '') {
        $price_query['value'] = $price_max;
        $price_query['compare'] = '<=';
        $price_query['type'] = 'NUMERIC';
    }
    
    $meta_query[] = $price_query;
}

if ($year_min !== '' || $year_max !== '') {
    $year_query = array('key' => 'year');
    
    if ($year_min !== '' && $year_max !== '') {
        $year_query['value'] = array($year_min, $year_max);
        $year_query['compare'] = 'BETWEEN';
        $year_query['type'] = 'NUMERIC';
    } elseif ($year_min !== '') {
        $year_query['value'] = $year_min;
        $year_query['compare'] = '>=';
        $year_query['type'] = 'NUMERIC';
    } elseif ($year_max !== '') {
        $year_query['value'] = $year_max;
        $year_query['compare'] = '<=';
        $year_query['type'] = 'NUMERIC';
    }
    
    $meta_query[] = $year_query;
}

if (count($meta_query) > 1) {
    $query_args['meta_query'] = $meta_query;
}

$sculptures = new WP_Query($query_args);

function sculpture_search_where_filter($where, $query) {
    global $wpdb, $sculpture_search_term;
    
    if (!empty($sculpture_search_term) && $query->get('post_type') === 'sculpture') {
        $like = '%' . $wpdb->esc_like($sculpture_search_term) . '%';
        $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", $like);
        
        // Reset global after use
        $sculpture_search_term = '';
    }
    
    return $where;
}

// Get unique materials
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

// Get price range
$price_range_query = new WP_Query(array(
    'post_type' => 'sculpture',
    'posts_per_page' => -1,
    'fields' => 'ids',
));
$min_price = PHP_INT_MAX;
$max_price = 0;
if ($price_range_query->have_posts()) {
    while ($price_range_query->have_posts()) {
        $price_range_query->the_post();
        $price = get_field('price');
        if ($price) {
            $min_price = min($min_price, intval($price));
            $max_price = max($max_price, intval($price));
        }
    }
    wp_reset_postdata();
}
if ($min_price === PHP_INT_MAX) $min_price = 0;
if ($max_price === 0) $max_price = 10000;

// Get year range
$year_range_query = new WP_Query(array(
    'post_type' => 'sculpture',
    'posts_per_page' => -1,
    'fields' => 'ids',
));
$min_year = PHP_INT_MAX;
$max_year = 0;
if ($year_range_query->have_posts()) {
    while ($year_range_query->have_posts()) {
        $year_range_query->the_post();
        $year = get_field('year');
        if ($year) {
            $min_year = min($min_year, intval($year));
            $max_year = max($max_year, intval($year));
        }
    }
    wp_reset_postdata();
}
if ($min_year === PHP_INT_MAX) $min_year = date('Y') - 50;
if ($max_year === 0) $max_year = date('Y');
?>

<div class="sculpture-archive">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <h1 class="archive-title">Sculpture Gallery</h1>
        <p class="archive-subtitle">Explore our collection of original artworks</p>
    </header>

    <!-- Modern Filters -->
<div class="sculpture-filters-modern">
    <form method="GET" action="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="filters-form-modern">
        
        <!-- Compact Top Bar (Always Visible) -->
        <div class="filters-compact-bar">
            
            <!-- Search -->
            <div class="filter-search-modern">
                <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <input 
                    type="text" 
                    name="search_query" 
                    placeholder="Search sculptures..."
                    value="<?php echo esc_attr($search); ?>"
                    class="search-input-modern"
                >
            </div>
            
            <!-- Sort Dropdown -->
            <div class="filter-sort-modern">
                <select name="orderby" class="sort-select-modern" onchange="this.form.submit()">
                    <option value="date" <?php selected($orderby, 'date'); ?>>Latest</option>
                    <option value="title" <?php selected($orderby, 'title'); ?>>A-Z</option>
                    <option value="year" <?php selected($orderby, 'year'); ?>>Newest Year</option>
                    <option value="price_low" <?php selected($orderby, 'price_low'); ?>>Price: Low</option>
                    <option value="price_high" <?php selected($orderby, 'price_high'); ?>>Price: High</option>
                </select>
            </div>
            
            <!-- Featured Toggle -->
            <div class="filter-toggle-modern">
                <label class="toggle-switch">
                    <input type="checkbox" name="featured" value="yes" <?php checked($featured_filter, 'yes'); ?> onchange="this.form.submit()">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Featured</span>
            </div>
            
            <!-- Advanced Toggle Button -->
            <button type="button" class="btn-toggle-advanced" id="toggleAdvanced">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
                <span>Advanced Filters</span>
                <svg class="chevron" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                </svg>
            </button>
            
        </div>
        
        <!-- Advanced Filters (Collapsible) -->
        <div class="filters-advanced-panel" id="advancedPanel">
            
            <!-- Dropdowns Row -->
            <div class="filters-dropdowns-row">
                
                <!-- Availability Dropdown -->
                <div class="filter-dropdown-group">
                    <label class="filter-dropdown-label">Availability:</label>
                    <select name="availability" class="filter-dropdown-select">
                        <option value="">All Sculptures</option>
                        <option value="Available" <?php selected($availability_filter, 'Available'); ?>>Available</option>
                        <option value="Sold" <?php selected($availability_filter, 'Sold'); ?>>Sold</option>
                        <option value="Reserved" <?php selected($availability_filter, 'Reserved'); ?>>Reserved</option>
                    </select>
                </div>
                
                <!-- Materials Dropdown -->
                <?php if (!empty($all_materials)): ?>
                <div class="filter-dropdown-group">
                    <label class="filter-dropdown-label">Material:</label>
                    <select name="materials" class="filter-dropdown-select">
                        <option value="">All Materials</option>
                        <?php foreach ($all_materials as $material): ?>
                            <option value="<?php echo esc_attr($material); ?>" <?php selected($materials_filter, $material); ?>>
                                <?php echo esc_html($material); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
            </div>
            
            <!-- Range Sliders Row -->
            <div class="filters-sliders-row">
                
                <!-- Price Range Slider -->
                <div class="slider-group">
                    <div class="slider-header">
                        <span class="slider-label">Price Range</span>
                        <span class="slider-value" id="priceValue">€<?php echo $price_min ?: $min_price; ?> - €<?php echo $price_max ?: $max_price; ?></span>
                    </div>
                    <div class="dual-slider">
                        <input 
                            type="range" 
                            id="priceMin" 
                            name="price_min" 
                            min="<?php echo $min_price; ?>" 
                            max="<?php echo $max_price; ?>" 
                            value="<?php echo $price_min ?: $min_price; ?>"
                            class="slider-input slider-min"
                        >
                        <input 
                            type="range" 
                            id="priceMax" 
                            name="price_max" 
                            min="<?php echo $min_price; ?>" 
                            max="<?php echo $max_price; ?>" 
                            value="<?php echo $price_max ?: $max_price; ?>"
                            class="slider-input slider-max"
                        >
                        <div class="slider-track"></div>
                        <div class="slider-range" id="priceRange"></div>
                    </div>
                </div>
                
                <!-- Year Range Slider -->
                <div class="slider-group">
                    <div class="slider-header">
                        <span class="slider-label">Year Range</span>
                        <span class="slider-value" id="yearValue"><?php echo $year_min ?: $min_year; ?> - <?php echo $year_max ?: $max_year; ?></span>
                    </div>
                    <div class="dual-slider">
                        <input 
                            type="range" 
                            id="yearMin" 
                            name="year_min" 
                            min="<?php echo $min_year; ?>" 
                            max="<?php echo $max_year; ?>" 
                            value="<?php echo $year_min ?: $min_year; ?>"
                            class="slider-input slider-min"
                        >
                        <input 
                            type="range" 
                            id="yearMax" 
                            name="year_max" 
                            min="<?php echo $min_year; ?>" 
                            max="<?php echo $max_year; ?>" 
                            value="<?php echo $year_max ?: $max_year; ?>"
                            class="slider-input slider-max"
                        >
                        <div class="slider-track"></div>
                        <div class="slider-range" id="yearRange"></div>
                    </div>
                </div>
                
            </div>
            
            <!-- Action Buttons -->
            <div class="filters-actions">
                <button type="submit" class="btn-apply-filters">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                    Apply Filters
                </button>
                <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-clear-filters">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                    Clear All
                </a>
            </div>
            
        </div>
        
    </form>
</div>

    <!-- Results Info -->
    <?php if ($sculptures->have_posts()): ?>
        <div class="results-info-modern">
            <span class="results-count"><?php echo $sculptures->found_posts; ?></span>
            <span class="results-text">sculptures found</span>
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
        
        <div class="no-sculptures-modern">
            <svg width="80" height="80" fill="currentColor" viewBox="0 0 16 16">
                <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
            <h3>No sculptures found</h3>
            <p>Try adjusting your filters to see more results</p>
            <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-clear-filters">Clear All Filters</a>
        </div>
        
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
    
</div>

<!-- Slider JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Advanced Filters Toggle
    const toggleBtn = document.getElementById('toggleAdvanced');
    const advancedPanel = document.getElementById('advancedPanel');
    
    if (toggleBtn && advancedPanel) {
        // Check if filters are active - auto-open if yes
        const hasActiveFilters = <?php 
            echo ($availability_filter || $materials_filter || $price_min || $price_max || $year_min || $year_max) ? 'true' : 'false'; 
        ?>;
        
        if (hasActiveFilters) {
            advancedPanel.classList.add('open');
            toggleBtn.classList.add('active');
        }
        
        toggleBtn.addEventListener('click', function() {
            advancedPanel.classList.toggle('open');
            toggleBtn.classList.toggle('active');
        });
    }
    
    // Price Slider
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const priceValue = document.getElementById('priceValue');
    const priceRange = document.getElementById('priceRange');
    
    function updatePriceSlider() {
        const min = parseInt(priceMin.value);
        const max = parseInt(priceMax.value);
        
        if (min > max) {
            priceMin.value = max;
            return;
        }
        
        priceValue.textContent = '€' + min.toLocaleString() + ' - €' + max.toLocaleString();
        
        const percentMin = ((min - priceMin.min) / (priceMin.max - priceMin.min)) * 100;
        const percentMax = ((max - priceMax.min) / (priceMax.max - priceMax.min)) * 100;
        
        priceRange.style.left = percentMin + '%';
        priceRange.style.width = (percentMax - percentMin) + '%';
    }
    
    if (priceMin && priceMax) {
        priceMin.addEventListener('input', updatePriceSlider);
        priceMax.addEventListener('input', updatePriceSlider);
        updatePriceSlider();
    }
    
    // Year Slider
    const yearMin = document.getElementById('yearMin');
    const yearMax = document.getElementById('yearMax');
    const yearValue = document.getElementById('yearValue');
    const yearRange = document.getElementById('yearRange');
    
    function updateYearSlider() {
        const min = parseInt(yearMin.value);
        const max = parseInt(yearMax.value);
        
        if (min > max) {
            yearMin.value = max;
            return;
        }
        
        yearValue.textContent = min + ' - ' + max;
        
        const percentMin = ((min - yearMin.min) / (yearMin.max - yearMin.min)) * 100;
        const percentMax = ((max - yearMax.min) / (yearMax.max - yearMax.min)) * 100;
        
        yearRange.style.left = percentMin + '%';
        yearRange.style.width = (percentMax - percentMin) + '%';
    }
    
    if (yearMin && yearMax) {
        yearMin.addEventListener('input', updateYearSlider);
        yearMax.addEventListener('input', updateYearSlider);
        updateYearSlider();
    }
});
</script>

<?php get_footer(); ?>