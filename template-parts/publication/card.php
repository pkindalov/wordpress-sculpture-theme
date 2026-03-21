<?php
/**
 * Publication Card
 *
 * Template part for displaying a publication as a card
 *
 * @package Sculpture_Theme
 */

$publication_id = get_the_ID();
$article_type = get_field("article_type", $publication_id);
$type_label = publication_get_type_label($article_type);
$meta = publication_get_meta($publication_id);
$external_url = get_field("external_url", $publication_id);
$original_label = get_current_active_language() === 'bg' ? common_translations['bg']['Original'] : common_translations['en']['Източник'];
$read_more_label = get_current_active_language() === 'bg' ? buttons['bg']['Read More'] : buttons['en']['Прочети Повече'];

?>

<article class="publication-card publication-type-<?php echo esc_attr(
    $article_type,
); ?>">
    
    <?php if (has_post_thumbnail()): ?>
    <div class="card-image">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail("medium"); ?>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="card-content">
        
        <!-- Type Badge -->
        <span class="publication-type-badge"><?php echo esc_html(
            $type_label,
        ); ?></span>
        
        <!-- Title -->
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <!-- Meta -->
        <?php if ($meta): ?>
        <div class="card-meta">
            <?php echo esc_html($meta); ?>
        </div>
        <?php endif; ?>
        
        <!-- Excerpt -->
        <?php if (has_excerpt()): ?>
        <div class="card-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20, "..."); ?>
        </div>
        <?php endif; ?>
        
        <!-- Footer -->
        <div class="card-footer">
            <a href="<?php the_permalink(); ?>" class="read-more">
                <?php _e($read_more_label, "sculpture-theme"); ?> →
            </a>
            
            <?php if ($external_url): ?>
            <a href="<?php echo esc_url(
                $external_url,
            ); ?>" class="external-link" target="_blank" rel="noopener">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M12 8.5v3.5a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1h3.5M9 3h4m0 0v4m0-4L7 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <?php _e($original_label, "sculpture-theme"); ?>
            </a>
            <?php endif; ?>
        </div>
        
    </div>
    
</article>
