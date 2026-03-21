<?php
/**
 * Sculpture Info Component
 * Technical details grid
 */
?>

<div class="sculpture-info">
    
    <?php if ($year = get_field("year")): ?>
        <div class="info-box">
            <div class="label">
                <?php echo mb_strtoupper(translate_on_active_lang("product_data", "year")); ?>
            </div>
            <div class="value"><?php echo esc_html($year); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($materials = get_field("materials")): ?>
        <div class="info-box">
            <div class="label">
                <?php echo mb_strtoupper(translate_on_active_lang("product_data", "materials")); ?>
                    
                </div>
            <div class="value"><?php echo mb_strtoupper(translate_on_active_lang("material", esc_html($materials))); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($dimensions = get_field("dimensions")): ?>
        <div class="info-box">
            <div class="label"><?php echo mb_strtoupper(translate_on_active_lang("product_data", "dimensions")); ?></div>
            <div class="value"><?php echo esc_html($dimensions); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($price = get_field("price")): ?>
        <div class="info-box info-box-price">
            <div class="label"><?php echo mb_strtoupper(translate_on_active_lang("product_data", "price")); ?></div>
            <div class="value">
                <?php 
                    echo esc_html(number_format($price, 0));
                    echo get_field("currency")
                    ? esc_html(get_field("currency"))
                    : "";
                ?>
                
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($availability = get_field("availability")): ?>
        <div class="info-box">
            <div class="label"><?php echo mb_strtoupper(translate_on_active_lang("product_data", "availability")); ?></div>
            <div class="value">
                <?php echo mb_strtoupper(translate_on_active_lang("availability", esc_html($availability))); ?>
            </div>
        </div>
    <?php endif; ?>
    
</div>
