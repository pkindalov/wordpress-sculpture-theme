<?php
/**
 * Single Publication Template
 *
 * @package Sculpture_Theme
 */

get_header();

while (have_posts()):

    the_post();

    $article_type = get_field("article_type");
    $type_label = publication_get_type_label($article_type);
    $publication = get_field("publication");
    $date = publication_get_date();
    $author = get_field("author");
    $external_url = get_field("external_url");
    ?>

<article class="single-publication publication-type-<?php echo esc_attr(
    $article_type,
); ?>">
    
    <div class="publication-container">
        
        <!-- Back Navigation -->
        <div class="publication-navigation">
            <a href="<?php echo get_post_type_archive_link(
                "publication",
            ); ?>" class="back-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M12.5 15l-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php _e("Back to Publications", "sculpture-theme"); ?>
            </a>
        </div>
        
        <!-- Header -->
        <header class="publication-header">
            
            <!-- Type Badge -->
            <span class="publication-type-badge"><?php echo esc_html(
                $type_label,
            ); ?></span>
            
            <!-- Title -->
            <h1 class="publication-title"><?php the_title(); ?></h1>
            
            <!-- Meta Info -->
            <div class="publication-meta">
                <?php if ($publication): ?>
                    <span class="meta-item">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M3 5h12M3 9h12M3 13h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <rect x="2" y="2" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <?php echo esc_html($publication); ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($date): ?>
                    <span class="meta-item">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="2" y="3" width="14" height="13" rx="1" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M2 7h14M5 1v2M13 1v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <?php echo esc_html($date); ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($author): ?>
                    <span class="meta-item">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <circle cx="9" cy="5" r="3" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M3 15c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <?php echo esc_html($author); ?>
                    </span>
                <?php endif; ?>
            </div>
            
        </header>
        
        <!-- Featured Image -->
        <?php if (has_post_thumbnail()): ?>
        <div class="publication-featured-image">
            <?php the_post_thumbnail("large"); ?>
        </div>
        <?php endif; ?>
        
        <!-- Content -->
        <div class="publication-content">
            <?php the_content(); ?>
        </div>
        
        <!-- External URL -->
        <?php if ($external_url): ?>
        <div class="publication-external">
            <div class="external-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6m0 0v6m0-6L10 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="external-content">
                    <span class="external-label"><?php _e(
                        "Original Publication",
                        "sculpture-theme",
                    ); ?></span>
                    <a href="<?php echo esc_url(
                        $external_url,
                    ); ?>" class="external-link" target="_blank" rel="noopener">
                        <?php echo esc_html($external_url); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Footer Navigation -->
        <footer class="publication-footer">
            <a href="<?php echo get_post_type_archive_link(
                "publication",
            ); ?>" class="back-button">
                ← <?php _e("View All Publications", "sculpture-theme"); ?>
            </a>
        </footer>
        
    </div>
    
</article>

<?php
endwhile;
?>

<?php get_footer(); ?>
