<?php
/**
 * Tests for publication date and meta helpers.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests\Unit;

use Brain\Monkey\Functions;
use Sculpture\Tests\TestCase;

class PublicationTest extends TestCase
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

    public function test_date_formats_ymd_to_dotted(): void
    {
        $this->stubFields(['publication_date' => '20260623']);
        $this->assertSame('23.06.2026', publication_get_date(1));
    }

    public function test_date_empty_when_field_missing(): void
    {
        $this->stubFields([]);
        $this->assertSame('', publication_get_date(1));
    }

    public function test_date_empty_when_unparseable(): void
    {
        $this->stubFields(['publication_date' => 'not-a-date']);
        $this->assertSame('', publication_get_date(1));
    }

    public function test_meta_joins_publication_date_and_author(): void
    {
        Functions\when('pll_current_language')->justReturn('en');
        $this->stubFields([
            'publication'      => 'Art Weekly',
            'publication_date' => '20260623',
            'author'           => 'Jane Doe',
        ]);
        $this->assertSame('Art Weekly • 23.06.2026 • Author: Jane Doe', publication_get_meta(1));
    }

    public function test_meta_omits_missing_parts(): void
    {
        $this->stubFields([
            'publication'      => 'Art Weekly',
            'publication_date' => null,
            'author'           => null,
        ]);
        $this->assertSame('Art Weekly', publication_get_meta(1));
    }

    public function test_type_label_in_english(): void
    {
        Functions\when('pll_current_language')->justReturn('en');
        $this->assertSame('Written by me', publication_get_type_label('by_me'));
        $this->assertSame('Written about me', publication_get_type_label('about_me'));
    }

    public function test_type_label_empty_for_unknown_type(): void
    {
        $this->assertSame('', publication_get_type_label('bogus'));
    }
}
