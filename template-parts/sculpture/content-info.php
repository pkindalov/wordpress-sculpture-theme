<?php
/**
 * Sculpture Info Box Component
 * Displays all ACF technical details
 */

// Get all fields
$year = get_field('year');
$materials = get_field('materials');
$dimensions = get_field('dimensions');
$price = get_field('price');
$currency = get_field('currency');
$availability = get_field('availability');

// Only show box if at least one field has value
if ($year || $materials || $dimensions || $price || $availability):
?>

<div class="sculpture-info-box">
    <h2 class="info-box-title">Sculpture Details</h2>
    
    <div class="sculpture-info-grid">
        
        <?php if ($year): ?>
            <div class="info-item">
                <span class="info-label">Year:</span>
                <span class="info-value"><?php echo esc_html($year); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($materials): ?>
            <div class="info-item">
                <span class="info-label">Materials:</span>
                <span class="info-value"><?php echo esc_html($materials); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($dimensions): ?>
            <div class="info-item">
                <span class="info-label">Dimensions:</span>
                <span class="info-value"><?php echo esc_html($dimensions); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($price): ?>
            <div class="info-item">
                <span class="info-label">Price:</span>
                <span class="info-value">
                    <?php 
                    if ($currency) {
                        echo esc_html($currency) . ' ';
                    }
                    echo esc_html(number_format($price, 2)); 
                    ?>
                </span>
            </div>
        <?php endif; ?>
        
        <?php if ($availability): ?>
            <div class="info-item">
                <span class="info-label">Availability:</span>
                <span class="info-value availability-<?php echo esc_attr(strtolower($availability)); ?>">
                    <?php echo esc_html($availability); ?>
                </span>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<?php endif; ?>