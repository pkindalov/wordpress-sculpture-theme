<?php
/**
 * Base test case wiring Brain Monkey in/out for each test.
 *
 * @package Sculpture_Theme
 */

namespace Sculpture\Tests;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();

        // The output-escaping helpers are WordPress concerns, not logic under
        // test here. Stub them as pass-through so assertions read the raw value.
        Functions\when('esc_html')->returnArg();
        Functions\when('esc_attr')->returnArg();
        Functions\when('esc_url')->returnArg();

        // Default the active language to Bulgarian (the theme's fallback).
        // Once Brain Monkey defines pll_current_language in any test, PHP keeps
        // it defined process-wide, so we stub it everywhere for determinism.
        // Tests that need English override this with their own expectation.
        Functions\when('pll_current_language')->justReturn('bg');
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
