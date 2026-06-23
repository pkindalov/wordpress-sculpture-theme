<?php
/**
 * Tests for testimonial star and meta helpers.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests\Unit;

use Brain\Monkey\Functions;
use Sculpture\Tests\TestCase;

class TestimonialTest extends TestCase
{
    public function test_stars_renders_three_filled_two_empty(): void
    {
        $html = testimonial_get_stars(3);
        $this->assertSame(3, substr_count($html, 'star filled'));
        $this->assertSame(2, substr_count($html, 'star empty'));
    }

    public function test_stars_all_empty_for_zero_rating(): void
    {
        $html = testimonial_get_stars(0);
        $this->assertSame(0, substr_count($html, 'star filled'));
        $this->assertSame(5, substr_count($html, 'star empty'));
    }

    public function test_stars_all_filled_for_max_rating(): void
    {
        $html = testimonial_get_stars(5);
        $this->assertSame(5, substr_count($html, 'star filled'));
        $this->assertSame(0, substr_count($html, 'star empty'));
    }

    public function test_meta_uses_client_name_and_company(): void
    {
        Functions\when('get_field')->alias(static function ($name, $post_id = null) {
            $map = [
                'client_name'    => 'Jane Doe',
                'client_company' => 'Acme Galleries',
            ];
            return $map[$name] ?? null;
        });

        $html = testimonial_get_meta(1);
        $this->assertStringContainsString('Jane Doe', $html);
        $this->assertStringContainsString('Acme Galleries', $html);
        $this->assertStringContainsString('author-company', $html);
    }

    public function test_meta_falls_back_to_post_title_without_company(): void
    {
        Functions\when('get_field')->justReturn(null);
        Functions\when('get_the_title')->justReturn('Anonymous Client');

        $html = testimonial_get_meta(1);
        $this->assertStringContainsString('Anonymous Client', $html);
        $this->assertStringNotContainsString('author-company', $html);
    }
}
