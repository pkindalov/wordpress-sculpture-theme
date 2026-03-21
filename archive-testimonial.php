<?php
/**
 * Archive template for Testimonials
 *
 * @package Sculpture_Theme
 */

get_header();

$paged = isset($_GET["pg"]) ? intval($_GET["pg"]) : 1;
$per_page = 12;

// Get published testimonials
$args = [
    "post_type" => "testimonial",
    "posts_per_page" => $per_page,
    "paged" => $paged,
    "post_status" => "publish",
    "orderby" => "date",
    "order" => "DESC",
];

$testimonials_query = new WP_Query($args);
$back_to_home_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Back to Home'] : buttons['en']['Към Начална Страница'];
$client_testimonials_label = get_current_active_language() === 'bg' ? common_translations['bg']['Client Testimonials'] : common_translations['en']['Отзиви на клиенти'];
$client_testimonials_subhead = get_current_active_language() === 'bg' ? common_translations['bg']['What our clients say about working with us'] : common_translations['en']['Какво казват нашите клиенти за работата с нас'];
$share_experience_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Share Your Experience'] : buttons['en']['Напишете отзив'];
$previous_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Previous'] : buttons['en']['Предишна'];
$next_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Next'] : buttons['en']['Следваща'];
$no_testimonials_label = get_current_active_language() === 'bg' ? common_translations['bg']['No testimonials yet. Be the first to share your experience'] : common_translations['en']['Все още няма отзиви. Бъдете първият, който ще сподели своя опит'];
$leave_review_btn_label = get_current_active_language() === 'bg' ? buttons['bg']['Leave a Review'] : buttons['en']['Оставете отзив'];

?>

<div class="testimonials-archive-container">
    
    <header class="archive-header">
        <a href="<?php echo home_url("/"); ?>" class="back-to-home">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.5 15l-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <?php _e($back_to_home_btn_label, "sculpture-theme"); ?>
        </a>
        <h1 class="archive-title"><?php _e(
            $client_testimonials_label,
            "sculpture-theme",
        ); ?></h1>
        <p class="archive-subtitle"><?php _e(
            $client_testimonials_subhead,
            "sculpture-theme",
        ); ?></p>
    </header>
    
    <!-- Add Review Button -->
    <div class="archive-cta">
        <button class="testimonial-trigger">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 1l2.5 6.5L19 8l-5 4.5L15.5 19 10 15l-5.5 4L6 12.5 1 8l6.5-.5z"/>
            </svg>
            <?php _e($share_experience_btn_label, "sculpture-theme"); ?>
        </button>
    </div>
    
    <div class="testimonials-content">
        
        <?php if ($testimonials_query->have_posts()): ?>
        
            <div class="testimonials-grid">
                <?php
                while ($testimonials_query->have_posts()):
                    $testimonials_query->the_post();
                    get_template_part("template-parts/testimonial/card");
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            
            <?php if ($testimonials_query->max_num_pages > 1): ?>
            <nav class="testimonials-pagination">
                <div class="pagination-numbers">
                    
                    <?php if ($paged > 1): ?>
                        <a href="<?php echo remove_query_arg(
                            "pg",
                        ); ?>" class="pagination-nav">
                            ← <?php _e($previous_btn_label, "sculpture-theme"); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php for (
                        $i = 1;
                        $i <= $testimonials_query->max_num_pages;
                        $i++
                    ): ?>
                        <?php if ($i === $paged): ?>
                            <span class="page-number current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo $i === 1
                                ? remove_query_arg("pg")
                                : add_query_arg(
                                    "pg",
                                    $i,
                                ); ?>" class="page-number">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($paged < $testimonials_query->max_num_pages): ?>
                        <a href="<?php echo add_query_arg(
                            "pg",
                            $paged + 1,
                        ); ?>" class="pagination-nav">
                            <?php _e($next_btn_label, "sculpture-theme"); ?> →
                        </a>
                    <?php endif; ?>
                    
                </div>
            </nav>
            <?php endif; ?>
        
        <?php else: ?>
        
            <div class="no-testimonials">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M32 56c13.255 0 24-10.745 24-24S45.255 8 32 8 8 18.745 8 32s10.745 24 24 24z"/>
                    <path d="M20 28c0-2.21 1.79-4 4-4s4 1.79 4 4M36 28c0-2.21 1.79-4 4-4s4 1.79 4 4M22 40c2.5 3 6 4 10 4s7.5-1 10-4"/>
                </svg>
                <p><?php _e(
                    $no_testimonials_label,
                    "sculpture-theme",
                ); ?></p>
                <button class="testimonial-trigger cta-button">
                    <?php _e($leave_review_btn_label, "sculpture-theme"); ?>
                </button>
            </div>
        
        <?php endif; ?>
        
    </div>
    
</div>

<?php get_footer(); ?>
