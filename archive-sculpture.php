<?php
/**
 * Archive Sculpture Template - Gallery View
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); 
?>

<div class="sculpture-archive">
    
    <!-- Archive Header -->
    <header class="archive-header">
        <h1 class="archive-title">Sculpture Gallery</h1>
        <p class="archive-subtitle">Explore our collection of original artworks</p>
    </header>

    <!-- Sculptures Grid -->
    <?php if (have_posts()): ?>
        
        <div class="sculptures-grid">
            
            <?php while (have_posts()): the_post(); ?>
                
                <article class="sculpture-card">
                    
                    <!-- Featured Badge -->
                    <?php if (get_field('featured')): ?>
                        <span class="card-badge">Featured</span>
                    <?php endif; ?>
                    
                    <!-- Image -->
                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="card-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php else: ?>
                            <div class="card-image card-image-placeholder">
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Content -->
                    <div class="card-content">
                        
                        <h2 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <!-- Meta Info -->
                        <div class="card-meta">
                            <?php 
                            $year = get_field('year');
                            $materials = get_field('materials');
                            
                            if ($year || $materials):
                            ?>
                                <span class="card-meta-item">
                                    <?php 
                                    echo $year ? esc_html($year) : '';
                                    if ($year && $materials) echo ' • ';
                                    echo $materials ? esc_html($materials) : '';
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Price/Status -->
                        <?php 
                        $price = get_field('price');
                        $availability = get_field('availability');
                        
                        if ($price || $availability):
                        ?>
                            <div class="card-footer">
                                <?php if ($price): ?>
                                    <span class="card-price">
                                        <?php 
                                        echo get_field('currency') ? esc_html(get_field('currency')) . ' ' : '';
                                        echo esc_html(number_format($price, 0));
                                        ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($availability): ?>
                                    <span class="card-status status-<?php echo esc_attr(sanitize_title($availability)); ?>">
                                        <?php echo esc_html($availability); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                </article>
                
            <?php endwhile; ?>
            
        </div>
        
        <!-- Pagination -->
        <?php
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
        ));
        ?>
        
    <?php else: ?>
        
        <div class="no-sculptures">
            <p>No sculptures found.</p>
        </div>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>