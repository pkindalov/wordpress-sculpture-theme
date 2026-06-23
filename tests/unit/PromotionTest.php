<?php
/**
 * Tests for sculpture promotion logic.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests\Unit;

use Brain\Monkey\Functions;
use Sculpture\Tests\TestCase;

class PromotionTest extends TestCase
{
    /**
     * Stub get_field() to read from an associative map keyed by field name.
     *
     * @param array<string, mixed> $fields
     */
    private function stubFields(array $fields): void
    {
        Functions\when('get_field')->alias(static function ($name, $post_id = null) use ($fields) {
            return $fields[$name] ?? null;
        });
    }

    public function test_not_on_promotion_when_flag_missing(): void
    {
        $this->stubFields(['on_promotion' => false]);
        $this->assertFalse(sculpture_is_on_promotion(1));
    }

    public function test_on_promotion_without_end_date(): void
    {
        $this->stubFields(['on_promotion' => true]);
        $this->assertTrue(sculpture_is_on_promotion(1));
    }

    public function test_promotion_active_before_end_date(): void
    {
        Functions\when('current_time')->justReturn('20260101');
        $this->stubFields([
            'on_promotion'   => true,
            'promotion_ends' => '20260601',
        ]);
        $this->assertTrue(sculpture_is_on_promotion(1));
    }

    public function test_promotion_expired_after_end_date(): void
    {
        Functions\when('current_time')->justReturn('20260601');
        $this->stubFields([
            'on_promotion'   => true,
            'promotion_ends' => '20260101',
        ]);
        $this->assertFalse(sculpture_is_on_promotion(1));
    }

    public function test_promotion_active_on_exact_end_date(): void
    {
        Functions\when('current_time')->justReturn('20260601');
        $this->stubFields([
            'on_promotion'   => true,
            'promotion_ends' => '20260601',
        ]);
        $this->assertTrue(sculpture_is_on_promotion(1));
    }

    public function test_price_returns_null_when_not_on_promotion(): void
    {
        $this->stubFields(['on_promotion' => false]);
        $this->assertNull(sculpture_get_promotion_price(1));
    }

    public function test_price_prefers_manual_value(): void
    {
        $this->stubFields([
            'on_promotion'         => true,
            'price'                => 1000,
            'promotion_price'      => 799.5,
            'promotion_percentage' => 50,
        ]);
        $this->assertSame(799.5, sculpture_get_promotion_price(1));
    }

    public function test_price_calculated_from_percentage(): void
    {
        $this->stubFields([
            'on_promotion'         => true,
            'price'                => 1000,
            'promotion_price'      => null,
            'promotion_percentage' => 25,
        ]);
        $this->assertSame(750.0, sculpture_get_promotion_price(1));
    }

    public function test_price_null_when_no_manual_and_no_percentage(): void
    {
        $this->stubFields([
            'on_promotion' => true,
            'price'        => 1000,
        ]);
        $this->assertNull(sculpture_get_promotion_price(1));
    }

    public function test_percentage_derived_from_manual_price(): void
    {
        $this->stubFields([
            'on_promotion'    => true,
            'price'           => 1000,
            'promotion_price' => 750,
        ]);
        // (1 - 750/1000) * 100 = 25
        $this->assertSame(25, sculpture_get_promotion_percentage(1));
    }

    public function test_percentage_returns_explicit_value(): void
    {
        $this->stubFields([
            'on_promotion'         => true,
            'promotion_percentage' => 30,
        ]);
        $this->assertSame(30, sculpture_get_promotion_percentage(1));
    }

    public function test_percentage_null_when_not_on_promotion(): void
    {
        $this->stubFields(['on_promotion' => false]);
        $this->assertNull(sculpture_get_promotion_percentage(1));
    }
}
