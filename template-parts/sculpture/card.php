<?php
/**
 * Sculpture Card Component
 * Used in archive, search results, related sculptures, etc.
 * 
 * @package Sculpture_Theme
 * @since   1.0.0
 */
?>

<article class="sculpture-card <?php echo get_field('featured') ? 'is-featured' : ''; ?>">
    
    <!-- Featured Badge -->
    <?php if (get_field("featured")): ?>
        <span class="card-badge">Featured</span>
    <?php endif; ?>
    
    <!-- Image -->
    <a href="<?php the_permalink(); ?>" class="card-image-link">
        <?php if (has_post_thumbnail()): ?>
            <div class="card-image">
                <?php the_post_thumbnail("large"); ?>
            </div>
        <?php else: ?>
            <div class="card-image card-image-placeholder">
                <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background -->
                    <rect width="400" height="400" fill="#DDE7D1"/>
                    
                    <!-- Camera Icon (centered) -->
                    <g transform="translate(200, 200)">
                        
                        <!-- Camera body -->
                        <rect x="-60" y="-35" width="120" height="80" rx="8" 
                              fill="none" stroke="#1F3A2A" stroke-width="4" opacity="0.3"/>
                        
                        <!-- Lens -->
                        <circle cx="0" cy="5" r="30" 
                                fill="none" stroke="#1F3A2A" stroke-width="4" opacity="0.3"/>
                        
                        <circle cx="0" cy="5" r="18" 
                                fill="none" stroke="#40543D" stroke-width="3" opacity="0.25"/>
                        
                        <!-- Viewfinder -->
                        <rect x="-20" y="-50" width="40" height="12" rx="3"
                              fill="#40543D" opacity="0.2"/>
                        
                        <!-- Flash -->
                        <circle cx="35" cy="-20" r="8" fill="#E7C871" opacity="0.4"/>
                        
                        <!-- Shutter button -->
                        <rect x="45" y="-30" width="12" height="8" rx="2"
                              fill="#6A8B58" opacity="0.3"/>
                        
                    </g>
                    
                    <!-- Decorative frame corners (GOLD) -->
                    <line x1="60" y1="60" x2="100" y2="60" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="60" y1="60" x2="60" y2="100" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    
                    <line x1="340" y1="60" x2="300" y2="60" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="60" x2="340" y2="100" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    
                    <line x1="60" y1="340" x2="100" y2="340" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="60" y1="340" x2="60" y2="300" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    
                    <line x1="340" y1="340" x2="300" y2="340" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="340" x2="340" y2="300" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    
                    <!-- Text -->
                    <text x="200" y="330" 
                          font-family="Arial, sans-serif" 
                          font-size="14" 
                          font-weight="600"
                          fill="#6A8B58" 
                          text-anchor="middle"
                          letter-spacing="2">
                        NO IMAGE AVAILABLE
                    </text>
                </svg>
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
            $year = get_field("year");
            $materials = get_field("materials");

            if ($year || $materials): ?>
                <span class="card-meta-item">
                    <?php
                    echo $year ? esc_html($year) : "";
                    if ($year && $materials) {
                        echo " • ";
                    }
                    echo $materials ? esc_html($materials) : "";
                    ?>
                </span>
            <?php endif;
            ?>
        </div>
        
        <!-- Price/Status -->
        <?php
        $price = get_field("price");
        $availability = get_field("availability");

        if ($price || $availability): ?>
            <div class="card-footer">
                <?php if ($price): ?>
                    <span class="card-price">
                        <?php
                        echo get_field("currency")
                            ? esc_html(get_field("currency")) . " "
                            : "";
                        echo esc_html(number_format($price, 0));
                        ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($availability): ?>
                    <span class="card-status status-<?php echo esc_attr(
                        sanitize_title($availability),
                    ); ?>">
                        <?php echo esc_html($availability); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif;
        ?>
        
    </div>
    
</article>
