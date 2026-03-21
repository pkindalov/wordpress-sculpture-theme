<?php
/**
 * Sculpture Filters Component
 *
 * Displays modern filter UI for sculpture archive
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

$filters = isset($args["filters"]) ? $args["filters"] : [];
$filter_data = isset($args["filter_data"]) ? $args["filter_data"] : [];
$currency = get_field('currency');
?>

<div class="sculpture-filters-modern">
    <form method="GET" action="<?php echo esc_url(
        get_post_type_archive_link("sculpture"),
    ); ?>" class="filters-form-modern">
        
        <!-- Compact Bar -->
        <div class="filters-compact-bar">
            
            <!-- Search -->
            <div class="filter-search-modern">
                <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <input type="text" name="search_query" placeholder="<?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Search...'] : filters_translations['en']['Търси...']); ?>" class="search-input-modern">
            </div>
            
            <!-- Sort -->
            <div class="filter-sort-modern">
                <select name="orderby" class="sort-select-modern" onchange="this.form.submit()">
                    <option value="date" <?php selected(
                        $filters["orderby"],
                        "date",
                    ); ?>><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Latest'] : filters_translations['en']['Най-Нови']); ?></option>
                    <option value="title" <?php selected(
                        $filters["orderby"],
                        "title",
                    ); ?>><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['A-Z'] : filters_translations['en']['А-Я']); ?></option>
                    <option value="year" <?php selected(
                        $filters["orderby"],
                        "year",
                    ); ?>><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Newest (by Year)'] : filters_translations['en']['Най-Нови (По година)']); ?></option>
                    <option value="price_low" <?php selected(
                        $filters["orderby"],
                        "price_low",
                    ); ?>><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Price: Low'] : filters_translations['en']['Цена: Възходяща']); ?></option>
                    <option value="price_high" <?php selected(
                        $filters["orderby"],
                        "price_high",
                    ); ?>><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Price: High'] : filters_translations['en']['Цена: Нисходяща']); ?></option>
                </select>
            </div>
            
            <!-- Featured Toggle -->
            <div class="filter-toggle-modern">
                <label class="toggle-switch">
                    <input type="checkbox" name="featured" value="yes" <?php checked(
                        $filters["featured"],
                        "yes",
                    ); ?> onchange="this.form.submit()">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Featured'] : filters_translations['en']['На Фокус']); ?></span>
            </div>

            <!-- On Promotion Toggle -->
        <div class="filter-toggle-modern">
            <label class="toggle-switch">
                <input type="checkbox" name="on_promotion" value="1"
                       <?php checked($filters["on_promotion"] ?? "", "1"); ?>
                       onchange="this.form.submit()">
                <span class="toggle-slider toggle-slider-promo"></span>
            </label>
            <span class="toggle-label toggle-label-promo"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['On Promotion'] : filters_translations['en']['На Промоция']); ?></span>
        </div>
            
            <!-- Advanced Toggle -->
            <button type="button" class="btn-toggle-advanced" id="toggleAdvanced">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>
                <span><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Advanced Filters'] : filters_translations['en']['Повече Филтри']); ?></span>
                <svg class="chevron" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                </svg>
            </button>
        </div>
        
        <!-- Advanced Panel -->
        <div class="filters-advanced-panel" id="advancedPanel">
            
            <!-- Dropdowns -->
            <div class="filters-dropdowns-row">
                <!-- Availability Dropdown (Dynamic from ACF) -->
<div class="filter-dropdown-group">
    <label class="filter-dropdown-label"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Availability'] : filters_translations['en']['Наличност']); ?>:</label>
    <select name="availability" class="filter-dropdown-select">
        <option value=""><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['All Sculptures'] : filters_translations['en']['Всички Скулптури']); ?></option>
        <?php
        // Get choices dynamically from ACF field
        $availability_choices = sculpture_get_acf_choices("availability");

        if (!empty($availability_choices)) {
            foreach ($availability_choices as $value => $label) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($value),
                    selected($filters["availability"], $value, false),
                    esc_html($label),
                );
            }
        } else {
            // Fallback if ACF field not found

            if(get_current_active_language() === "bg") {
                echo '<option value="available">' . availability_translations['bg']['available'] . '</option>';
                echo '<option value="sold">' . availability_translations['bg']['sold'] . '</option>';
                echo '<option value="reserved">' . availability_translations['bg']['reserved'] .'</option>';
                return;
            } 
            echo '<option value="available">Available</option>';
            echo '<option value="sold">Sold</option>';
            echo '<option value="reserved">Reserved</option>';
        }
        ?>
    </select>
</div>
                
                <!-- Materials Dropdown (Dynamic from ACF) -->
<div class="filter-dropdown-group">
    <label class="filter-dropdown-label"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Material'] : filters_translations['en']['Материал']); ?>:</label>
    <select name="materials" class="filter-dropdown-select">
        <option value=""><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['All Materials'] : filters_translations['en']['Всички Материали']); ?></option>
        <?php
        // Get choices dynamically from ACF field
        $material_choices = sculpture_get_acf_choices("materials");

        if (!empty($material_choices)) {
            foreach ($material_choices as $value => $label) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($value),
                    selected($filters["materials"], $value, false),
                    esc_html($label),
                );
            }
        } else {
            // Fallback: show materials that exist in sculptures
            if (!empty($filter_data["materials"])) {
                foreach ($filter_data["materials"] as $material) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($material),
                        selected($filters["materials"], $material, false),
                        esc_html($material),
                    );
                }
            }
        }
        ?>
    </select>
</div>


            </div>
            
            <!-- Sliders -->
            <div class="filters-sliders-row">
                <div class="slider-group">
                    <div class="slider-header">
                        <span class="slider-label"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Price Range'] : filters_translations['en']['Ценови Диапазон']); ?></span>
                        <span class="slider-value" id="priceValue">
                            <?php echo $currency; ?><?php echo $filters["price_min"] ?:
                                $filter_data["min_price"]; ?> - 
                            <?php echo $currency; ?><?php echo $filters["price_max"] ?:
                                $filter_data["max_price"]; ?>
                        </span>
                    </div>
                    <div class="dual-slider">
                        <input type="range" id="priceMin" name="price_min" 
                               min="<?php echo esc_attr(
                                   $filter_data["min_price"],
                               ); ?>" 
                               max="<?php echo esc_attr(
                                   $filter_data["max_price"],
                               ); ?>" 
                               value="<?php echo esc_attr(
                                   $filters["price_min"] ?:
                                   $filter_data["min_price"],
                               ); ?>" 
                               class="slider-input slider-min">
                        <input type="range" id="priceMax" name="price_max" 
                               min="<?php echo esc_attr(
                                   $filter_data["min_price"],
                               ); ?>" 
                               max="<?php echo esc_attr(
                                   $filter_data["max_price"],
                               ); ?>" 
                               value="<?php echo esc_attr(
                                   $filters["price_max"] ?:
                                   $filter_data["max_price"],
                               ); ?>" 
                               class="slider-input slider-max">
                        <div class="slider-track"></div>
                        <div class="slider-range" id="priceRange"></div>
                    </div>
                </div>
                
                <div class="slider-group">
                    <div class="slider-header">
                        <span class="slider-label"><?php echo (get_current_active_language() === 'bg' ? filters_translations['bg']['Year Range'] : filters_translations['en']['Годишен Диапазон']); ?></span>
                        <span class="slider-value" id="yearValue">
                            <?php echo $filters["year_min"] ?:
                                $filter_data["min_year"]; ?> - 
                            <?php echo $filters["year_max"] ?:
                                $filter_data["max_year"]; ?>
                        </span>
                    </div>
                    <div class="dual-slider">
                        <input type="range" id="yearMin" name="year_min" 
                               min="<?php echo esc_attr(
                                   $filter_data["min_year"],
                               ); ?>" 
                               max="<?php echo esc_attr(
                                   $filter_data["max_year"],
                               ); ?>" 
                               value="<?php echo esc_attr(
                                   $filters["year_min"] ?:
                                   $filter_data["min_year"],
                               ); ?>" 
                               class="slider-input slider-min">
                        <input type="range" id="yearMax" name="year_max" 
                               min="<?php echo esc_attr(
                                   $filter_data["min_year"],
                               ); ?>" 
                               max="<?php echo esc_attr(
                                   $filter_data["max_year"],
                               ); ?>" 
                               value="<?php echo esc_attr(
                                   $filters["year_max"] ?:
                                   $filter_data["max_year"],
                               ); ?>" 
                               class="slider-input slider-max">
                        <div class="slider-track"></div>
                        <div class="slider-range" id="yearRange"></div>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="filters-actions">
                <button type="submit" class="btn-apply-filters">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                    <?php echo (get_current_active_language() === 'bg' ? buttons['bg']['Apply Filters'] : buttons['en']['Приложи Филтри']); ?>
                </button>
                <a href="<?php echo esc_url(
                    get_post_type_archive_link("sculpture"),
                ); ?>" class="btn-clear-filters">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                    <?php echo (get_current_active_language() === 'bg' ? buttons['bg']['Clear All'] : buttons['en']['Премахни Филтри']); ?>
                </a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleAdvanced');
    const panel = document.getElementById('advancedPanel');
    
    if (toggleBtn && panel) {
        const hasFilters = <?php echo $filters["availability"] ||
        $filters["materials"] ||
        $filters["price_min"] ||
        $filters["price_max"] ||
        $filters["year_min"] ||
        $filters["year_max"]
            ? "true"
            : "false"; ?>;
        
        if (hasFilters) {
            panel.classList.add('open');
            toggleBtn.classList.add('active');
        }
        
        toggleBtn.addEventListener('click', function() {
            panel.classList.toggle('open');
            toggleBtn.classList.toggle('active');
        });
    }
    
    // Price slider
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const priceValue = document.getElementById('priceValue');
    const priceRange = document.getElementById('priceRange');
    
    function updatePrice() {
        const currencySign = "<?php echo $currency; ?>";
        if (!priceMin || !priceMax) return;
        const min = parseInt(priceMin.value);
        const max = parseInt(priceMax.value);
        if (min > max) { priceMin.value = max; return; }
        priceValue.textContent = currencySign + min.toLocaleString() + ' - ' + currencySign + max.toLocaleString();
        const pMin = ((min - priceMin.min) / (priceMin.max - priceMin.min)) * 100;
        const pMax = ((max - priceMax.min) / (priceMax.max - priceMax.min)) * 100;
        priceRange.style.left = pMin + '%';
        priceRange.style.width = (pMax - pMin) + '%';
    }
    
    if (priceMin && priceMax) {
        priceMin.addEventListener('input', updatePrice);
        priceMax.addEventListener('input', updatePrice);
        updatePrice();
    }
    
    // Year slider
    const yearMin = document.getElementById('yearMin');
    const yearMax = document.getElementById('yearMax');
    const yearValue = document.getElementById('yearValue');
    const yearRange = document.getElementById('yearRange');
    
    function updateYear() {
        if (!yearMin || !yearMax) return;
        const min = parseInt(yearMin.value);
        const max = parseInt(yearMax.value);
        if (min > max) { yearMin.value = max; return; }
        yearValue.textContent = min + ' - ' + max;
        const yMin = ((min - yearMin.min) / (yearMin.max - yearMin.min)) * 100;
        const yMax = ((max - yearMax.min) / (yearMax.max - yearMax.min)) * 100;
        yearRange.style.left = yMin + '%';
        yearRange.style.width = (yMax - yMin) + '%';
    }
    
    if (yearMin && yearMax) {
        yearMin.addEventListener('input', updateYear);
        yearMax.addEventListener('input', updateYear);
        updateYear();
    }
});
</script>
