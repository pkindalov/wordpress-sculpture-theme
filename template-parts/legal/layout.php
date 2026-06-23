<?php
/**
 * Legal Page Layout — shared by Terms & Privacy Policy
 *
 * Expects:
 *   $args['hero_badge']     string  — small uppercase label above the title
 *   $args['hero_title']     string  — main hero h1 text
 *   $args['hero_watermark'] string  — large watermark text (data-watermark attr)
 *   $args['toc']            array   — [ ['label' => '...', 'anchor' => '#...'], ... ]
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

$hero_badge     = isset( $args['hero_badge'] )     ? $args['hero_badge']     : 'Документ';
$hero_title     = isset( $args['hero_title'] )     ? $args['hero_title']     : get_the_title();
$hero_watermark = isset( $args['hero_watermark'] ) ? $args['hero_watermark'] : '';
$toc            = isset( $args['toc'] )            ? $args['toc']            : [];

$last_modified = get_the_modified_date( 'F Y' );
?>

<!-- Reading progress bar -->
<div class="legal-progress-bar" id="legal-progress-bar"></div>

<article class="legal-page">

    <!-- ── HERO ───────────────────────────────── -->
    <header class="legal-hero" data-watermark="<?php echo esc_attr( $hero_watermark ); ?>">
        <span class="legal-hero__badge"><?php echo esc_html( $hero_badge ); ?></span>
        <h1 class="legal-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
        <?php if ( $last_modified ) : ?>
            <p class="legal-hero__updated">
                Последна актуализация: <?php echo esc_html( $last_modified ); ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if ( ! empty( $toc ) ) : ?>
    <!-- ── TABLE OF CONTENTS ──────────────────── -->
    <nav class="legal-toc" aria-label="Съдържание">
        <div class="legal-toc__inner">
            <p class="legal-toc__label">Съдържание</p>
            <ul class="legal-toc__list">
                <?php foreach ( $toc as $item ) : ?>
                    <li>
                        <a href="<?php echo esc_attr( $item['anchor'] ); ?>">
                            <?php echo esc_html( $item['label'] ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
    <?php endif; ?>

    <!-- ── MAIN CONTENT ────────────────────────── -->
    <div class="legal-content">
        <?php the_content(); ?>
    </div>

    <!-- ── BACK TO TOP ──────────────────────────── -->
    <div class="legal-back-top">
        <a href="#top">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
            </svg>
            Обратно към началото
        </a>
    </div>

</article>

<!-- Reading progress bar script -->
<script>
(function () {
    var bar = document.getElementById('legal-progress-bar');
    if (!bar) return;
    function updateProgress() {
        var scrollTop  = window.scrollY || document.documentElement.scrollTop;
        var docHeight  = document.documentElement.scrollHeight - window.innerHeight;
        var progress   = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        bar.style.width = Math.min(progress, 100) + '%';
    }
    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
})();
</script>
