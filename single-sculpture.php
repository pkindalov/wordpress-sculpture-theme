<?php
if (!defined('ABSPATH')) exit;
get_header(); 
while (have_posts()) : the_post(); 
?>

<article class="sculpture-page">

    <?php if (has_post_thumbnail()): ?>
        <div class="sculpture-image">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

    <div class="sculpture-header">
        <h1><?php the_title(); ?></h1>
        <?php if ($s = get_field('short_description')): ?>
            <p class="subtitle"><?php echo esc_html($s); ?></p>
        <?php endif; ?>
    </div>

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

    <?php if (get_the_content()): ?>
        <div class="sculpture-description">
            <h2>About This Work</h2>
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

    <div class="sculpture-nav">
        <a href="<?php echo esc_url(get_post_type_archive_link('sculpture')); ?>" class="btn-back">← BACK TO GALLERY</a>
    </div>

</article>

<?php endwhile; get_footer(); ?>