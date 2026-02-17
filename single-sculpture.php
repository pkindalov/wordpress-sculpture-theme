<?php
/**
 * Single Sculpture Template
 *
 * Loads modular components from template-parts/sculpture/
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

if (!defined("ABSPATH")) {
    exit();
}

get_header();

while (have_posts()):
    the_post(); ?>

<article class="sculpture-page">
    
    <?php
    get_template_part("template-parts/sculpture/content", "header");
    get_template_part("template-parts/sculpture/content", "image");
    get_template_part("template-parts/sculpture/content", "info");
    get_template_part("template-parts/sculpture/content", "description");
    get_template_part("template-parts/sculpture/content", "navigation");
    ?>
    
</article>

<?php
endwhile;

get_footer();
