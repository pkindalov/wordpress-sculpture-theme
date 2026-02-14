<?php
/**
 * Sculpture Info Component
 * Technical details grid
 */
?>

<div class="sculpture-info">
    
    <?php if ($y = get_field('year')): ?>
        <div class="info-box">
            <div class="label">YEAR</div>
            <div class="value"><?php echo esc_html($y); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($m = get_field('materials')): ?>
        <div class="info-box">
            <div class="label">MATERIALS</div>
            <div class="value"><?php echo esc_html($m); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($d = get_field('dimensions')): ?>
        <div class="info-box">
            <div class="label">DIMENSIONS</div>
            <div class="value"><?php echo esc_html($d); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($p = get_field('price')): ?>
        <div class="info-box info-box-price">
            <div class="label">PRICE</div>
            <div class="value">
                <?php echo get_field('currency') ? esc_html(get_field('currency')) . ' ' : ''; ?>
                <?php echo esc_html(number_format($p, 0)); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($a = get_field('availability')): ?>
        <div class="info-box">
            <div class="label">STATUS</div>
            <div class="value"><?php echo esc_html($a); ?></div>
        </div>
    <?php endif; ?>
    
</div>