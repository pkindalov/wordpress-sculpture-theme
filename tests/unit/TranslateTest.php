<?php
/**
 * Tests for sculpture_translate() and language detection.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests\Unit;

use Brain\Monkey\Functions;
use Sculpture\Tests\TestCase;

class TranslateTest extends TestCase
{
    public function test_returns_empty_string_for_empty_input(): void
    {
        $this->assertSame('', sculpture_translate(''));
    }

    public function test_defaults_to_bulgarian(): void
    {
        // The base test case stubs Polylang to the theme's 'bg' fallback.
        $this->assertSame('bg', sculpture_get_current_language());
    }

    public function test_uses_polylang_language_lowercased(): void
    {
        Functions\when('pll_current_language')->justReturn('EN');
        $this->assertSame('en', sculpture_get_current_language());
    }

    public function test_translates_material_into_bulgarian(): void
    {
        // bg map keys are English; input is matched case-insensitively.
        $this->assertSame('Бронз', sculpture_translate('Bronze', 'material'));
    }

    public function test_translates_material_into_english(): void
    {
        Functions\when('pll_current_language')->justReturn('en');
        $this->assertSame('Bronze', sculpture_translate('Бронз', 'material'));
    }

    public function test_unknown_key_falls_back_to_original_text(): void
    {
        $this->assertSame('Nonexistent', sculpture_translate('Nonexistent', 'material'));
    }

    public function test_unknown_context_falls_back_to_original_text(): void
    {
        $this->assertSame('Bronze', sculpture_translate('Bronze', 'no_such_context'));
    }
}
