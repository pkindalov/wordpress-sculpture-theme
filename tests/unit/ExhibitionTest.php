<?php
/**
 * Tests for exhibition status and date-range helpers.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests\Unit;

use Brain\Monkey\Functions;
use Sculpture\Tests\TestCase;

class ExhibitionTest extends TestCase
{
    /**
     * @param array<string, mixed> $fields
     */
    private function stubFields(array $fields): void
    {
        Functions\when('get_field')->alias(static function ($name, $post_id = null) use ($fields) {
            return $fields[$name] ?? null;
        });
    }

    public function test_status_upcoming_when_dates_missing(): void
    {
        $this->stubFields([]);
        $this->assertSame('upcoming', exhibition_get_status(1));
    }

    public function test_status_current_when_today_inside_range(): void
    {
        Functions\when('current_time')->justReturn('20260315');
        $this->stubFields([
            'start_date' => '20260301',
            'end_date'   => '20260331',
        ]);
        $this->assertSame('current', exhibition_get_status(1));
    }

    public function test_status_upcoming_when_today_before_start(): void
    {
        Functions\when('current_time')->justReturn('20260101');
        $this->stubFields([
            'start_date' => '20260301',
            'end_date'   => '20260331',
        ]);
        $this->assertSame('upcoming', exhibition_get_status(1));
    }

    public function test_status_past_when_today_after_end(): void
    {
        Functions\when('current_time')->justReturn('20260601');
        $this->stubFields([
            'start_date' => '20260301',
            'end_date'   => '20260331',
        ]);
        $this->assertSame('past', exhibition_get_status(1));
    }

    public function test_is_current_true_for_active_exhibition(): void
    {
        Functions\when('current_time')->justReturn('20260315');
        $this->stubFields([
            'start_date' => '20260301',
            'end_date'   => '20260331',
        ]);
        $this->assertTrue(exhibition_is_current(1));
    }

    public function test_date_range_empty_when_dates_missing(): void
    {
        $this->stubFields([]);
        $this->assertSame('', exhibition_get_date_range(1));
    }

    public function test_date_range_same_month(): void
    {
        $this->stubFields([
            'start_date' => '20260310',
            'end_date'   => '20260315',
        ]);
        $this->assertSame('10–15 Mar 2026', exhibition_get_date_range(1));
    }

    public function test_date_range_same_year_different_month(): void
    {
        $this->stubFields([
            'start_date' => '20260310',
            'end_date'   => '20260415',
        ]);
        $this->assertSame('10 Mar – 15 Apr 2026', exhibition_get_date_range(1));
    }

    public function test_date_range_different_year(): void
    {
        $this->stubFields([
            'start_date' => '20251220',
            'end_date'   => '20260115',
        ]);
        $this->assertSame('20 Dec 2025 – 15 Jan 2026', exhibition_get_date_range(1));
    }

    public function test_status_label_maps_known_status_in_english(): void
    {
        // 'exhibition' context maps Bulgarian keys → English under 'en'; the
        // English source words fall through unchanged, which is the label shown.
        Functions\when('pll_current_language')->justReturn('en');
        $this->assertSame('Current', exhibition_get_status_label('current'));
        $this->assertSame('Upcoming', exhibition_get_status_label('upcoming'));
        $this->assertSame('Past', exhibition_get_status_label('past'));
    }

    public function test_status_label_maps_known_status_in_bulgarian(): void
    {
        $this->assertSame('Актуална', exhibition_get_status_label('current'));
    }

    public function test_status_label_empty_for_unknown_status(): void
    {
        $this->assertSame('', exhibition_get_status_label('bogus'));
    }
}
