<?php
/**
 * Sculpture Card Component
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

$post_id = get_the_ID();
$is_featured = get_field("featured", $post_id);
$is_on_promo = sculpture_is_on_promotion($post_id);
$price = get_field("price", $post_id);
$promo_price = sculpture_get_promotion_price($post_id);
$promo_pct = sculpture_get_promotion_percentage($post_id);
$promo_ends = get_field("promotion_ends", $post_id);
$year = get_field("year", $post_id);
$materials = get_field("materials", $post_id);
$availability = get_field("availability", $post_id);
$currency = get_field("currency", $post_id) ?: "€";
?>

<article class="sculpture-card <?php echo $is_featured
    ? "is-featured"
    : ""; ?> <?php echo $is_on_promo ? "is-on-promo" : ""; ?>">

    <!-- Badges -->
    <?php if ($is_on_promo && $promo_pct): ?>
        <span class="card-badge badge-promo">-<?php echo $promo_pct; ?>%</span>
    <?php elseif ($is_on_promo): ?>
        <!-- <span class="card-badge badge-promo">Promoted</span> -->
        <span class="card-badge badge-promo">
            <?php echo (get_current_active_language() === "bg" ? product_mode_translations['bg']['promoted'] : product_mode_translations['en']['Промоция']); ?>
        </span>
    <?php elseif ($is_featured): ?>
        <span class="card-badge badge-featured">
            <?php echo (get_current_active_language() === "bg" ? product_mode_translations['bg']['featured'] : product_mode_translations['en']['На Фокус']); ?>
        </span>
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
                    <rect width="400" height="400" fill="#DDE7D1"/>
                    <g transform="translate(200, 200)">
                        <rect x="-60" y="-35" width="120" height="80" rx="8" fill="none" stroke="#1F3A2A" stroke-width="4" opacity="0.3"/>
                        <circle cx="0" cy="5" r="30" fill="none" stroke="#1F3A2A" stroke-width="4" opacity="0.3"/>
                        <circle cx="0" cy="5" r="18" fill="none" stroke="#40543D" stroke-width="3" opacity="0.25"/>
                        <rect x="-20" y="-50" width="40" height="12" rx="3" fill="#40543D" opacity="0.2"/>
                        <circle cx="35" cy="-20" r="8" fill="#E7C871" opacity="0.4"/>
                    </g>
                    <line x1="60" y1="60" x2="100" y2="60" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="60" y1="60" x2="60" y2="100" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="60" x2="300" y2="60" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="60" x2="340" y2="100" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="60" y1="340" x2="100" y2="340" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="60" y1="340" x2="60" y2="300" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="340" x2="300" y2="340" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <line x1="340" y1="340" x2="340" y2="300" stroke="#E7C871" stroke-width="3" opacity="0.6"/>
                    <text x="200" y="330" font-family="Arial, sans-serif" font-size="14" font-weight="600" fill="#6A8B58" text-anchor="middle" letter-spacing="2">NO IMAGE AVAILABLE</text>
                </svg>
            </div>
        <?php endif; ?>
    </a>

    <!-- Content -->
    <div class="card-content">
        <h2 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <!-- Meta -->
        <?php if ($year || $materials): ?>
            <div class="card-meta">
                <span class="card-meta-item">
                    <?php
                    echo $year ? esc_html($year) : "";
                    if ($year && $materials) {
                        echo " • ";
                    }
                    echo $materials ? esc_html(translate_on_active_lang("material",$materials)) : "";
                    ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Price + Status -->
        <?php if ($price || $availability): ?>
            <div class="card-footer">

                <!-- Price -->
                <div class="card-price-wrapper">
                    <?php if ($is_on_promo && $promo_price): ?>
                        <span class="card-price-original">
                            <?php echo esc_html(
                                number_format($price, 0) . $currency . " ",
                            ); 
                            showPriceInLv($price);
                            ?>
                        </span>
                        <span class="card-price card-price-promo">
                            <?php echo esc_html(
                                number_format($promo_price, 0) . $currency . " ",
                            ); 
                                showPriceInLv($promo_price);
                            ?>
                        </span>
                    <?php elseif ($price): ?>
                        <span class="card-price">
                            <?php echo esc_html(
                                number_format($price, 0) . $currency . " ",
                            ); 
                                showPriceInLv($price);
                            ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Availability -->
                <?php if ($availability): ?>
                    <span class="card-status status-<?php echo esc_attr(
                        sanitize_title(get_translated_word("en", "availability", $availability)),
                    ); ?>">
                        <?php echo esc_html(translate_on_active_lang("availability", $availability)); ?>
                    </span>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Promotion Ends -->
        <?php if ($is_on_promo && $promo_ends): ?>
            <div class="card-promo-ends">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                </svg>
                <?php echo translate_on_active_lang("product_mode", "Ends"); ?> : <?php echo translate_date_current_lang(date("d M Y", strtotime($promo_ends))); ?>
            </div>
        <?php endif; ?>

    </div>

</article>
