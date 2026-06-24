<?php
/**
 * Integration tests for the theme's shortcodes.
 *
 * Exercises the real WP_Query / meta_query branching and the rendered output
 * wrapper for each homepage shortcode.
 *
 * @package Sculpture_Theme
 */

class ShortcodeTest extends WP_UnitTestCase
{
    /**
     * Create a published post of the given CPT with optional meta.
     *
     * @param string               $type
     * @param array<string, mixed> $meta
     * @param string               $title
     * @return int Post ID
     */
    private function makePost(string $type, array $meta = [], string $title = 'Untitled'): int
    {
        $post_id = self::factory()->post->create([
            'post_type'   => $type,
            'post_status' => 'publish',
            'post_title'  => $title,
        ]);

        foreach ($meta as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }

        return $post_id;
    }

    // ---- featured_sculptures --------------------------------------------

    public function test_featured_shortcode_is_empty_without_sculptures(): void
    {
        $this->assertSame('', do_shortcode('[featured_sculptures]'));
    }

    public function test_featured_shortcode_renders_all_sculptures(): void
    {
        $this->makePost('sculpture', [], 'Bronze A');
        $this->makePost('sculpture', [], 'Bronze B');

        $html = do_shortcode('[featured_sculptures]');

        $this->assertStringContainsString('homepage-sculptures', $html);
        $this->assertSame(2, substr_count($html, 'sculpture-card'));
    }

    // ---- promo_sculptures -----------------------------------------------

    public function test_promo_shortcode_is_empty_when_nothing_on_promotion(): void
    {
        $this->makePost('sculpture', [], 'Not On Promo');
        $this->assertSame('', do_shortcode('[promo_sculptures]'));
    }

    public function test_promo_shortcode_renders_only_promoted_sculptures(): void
    {
        $this->makePost('sculpture', ['on_promotion' => '1'], 'On Promo');
        $this->makePost('sculpture', [], 'Regular');

        $html = do_shortcode('[promo_sculptures]');

        $this->assertStringContainsString('homepage-promo', $html);
        $this->assertSame(1, substr_count($html, 'sculpture-card'));
    }

    public function test_promo_shortcode_excludes_expired_promotions(): void
    {
        $this->makePost('sculpture', [
            'on_promotion'   => '1',
            'promotion_ends' => '20200101', // long past
        ], 'Expired Promo');

        $this->assertSame('', do_shortcode('[promo_sculptures]'));
    }

    // ---- publications_showcase ------------------------------------------

    public function test_publications_shortcode_is_empty_without_publications(): void
    {
        $this->assertSame('', do_shortcode('[publications_showcase]'));
    }

    public function test_publications_shortcode_renders_section(): void
    {
        $this->makePost('publication', ['article_type' => 'by_me'], 'My Article');

        $html = do_shortcode('[publications_showcase]');

        $this->assertStringContainsString('homepage-publications-section', $html);
    }

    // ---- exhibitions_timeline -------------------------------------------

    public function test_exhibitions_timeline_is_empty_without_exhibitions(): void
    {
        $this->assertSame('', do_shortcode('[exhibitions_timeline]'));
    }

    public function test_exhibitions_timeline_renders_section(): void
    {
        $this->makePost('exhibition', [
            'start_date' => '20260301',
            'end_date'   => '20260331',
        ], 'Spring Show');

        $html = do_shortcode('[exhibitions_timeline]');

        $this->assertStringContainsString('homepage-exhibitions-section', $html);
    }

    // ---- testimonials_slider --------------------------------------------

    public function test_testimonials_shortcode_is_empty_without_testimonials(): void
    {
        $this->assertSame('', do_shortcode('[testimonials_slider]'));
    }

    public function test_testimonials_shortcode_renders_section(): void
    {
        $this->makePost('testimonial', ['rating' => 5], 'Happy Client');

        $html = do_shortcode('[testimonials_slider]');

        $this->assertStringContainsString('homepage-testimonials-section', $html);
    }
}
