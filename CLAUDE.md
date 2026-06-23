# CLAUDE.md — Sculpture Theme

Astra **child theme** for a sculptor portfolio (PHP / JavaScript / HTML / CSS). Text domain: `sculpture-theme`. Requires WordPress 5.0+, PHP 7.4+, Astra, and ACF.

## Working Philosophy

- Ask before coding if requirements are ambiguous; state assumptions explicitly.
- Prefer the simplest, most readable solution. No speculative features or premature abstraction.
- **Surgical changes**: touch only what the request requires. Don't reformat or "improve" adjacent code. Match the existing style.
- Remove only imports/functions *your* changes made unused; flag pre-existing dead code instead of deleting it.
- Fix deprecated WordPress functions when encountered and flag them.
- Never commit on behalf of the user.

## Architecture (how this theme is wired)

- `functions.php` is a thin loader — it only `require_once`s modules from `inc/` and registers a couple of theme-wide hooks. Keep new logic out of it; put it in the right `inc/` module.
- `inc/setup.php` — theme supports, menus, image sizes, CPT/init configuration.
- `inc/enqueue.php` — **all** style/script registration lives here. Never enqueue from templates.
- `inc/acf-functions.php` — ACF helpers and the `[acf field="..."]` shortcode. Only loaded when `get_field()` exists; guard new ACF code the same way.
- `inc/template-functions.php` — reusable display/helper functions.
- `templates/` — full page templates. `template-parts/` — reusable partials, grouped by post type (`sculpture/`, `exhibition/`, `publication/`, `testimonial/`, `global/`, `legal/`).
- Render partials with `get_template_part()`; pass data via `get_template_part($slug, $name, $args)` rather than globals.

Custom post types: `sculpture`, `exhibition`, `publication`, `testimonial`. Templates follow WP hierarchy (`single-{cpt}.php`, `archive-{cpt}.php`).

## PHP & WordPress Standards

- **Always guard direct access**: every PHP file starts with `if (!defined('ABSPATH')) { exit; }`.
- **Prefix everything** with `sculpture_` (functions) / `SCULPTURE_` (constants) to avoid collisions with Astra and plugins.
- **Escape on output — always, no exceptions.** This is the theme's weakest area, so treat it as a hard rule:
  - `esc_html()` / `esc_html_e()` for text, `esc_attr()` for attributes, `esc_url()` for URLs.
  - ACF: `the_field()` and echoing `get_field()` are **not** pre-escaped. Wrap them: `echo esc_html(get_field('x'))`, `echo esc_url(get_field('link'))`. Only use `wp_kses_post()` when the field is intentionally rich HTML.
- **Sanitize on input**: `sanitize_text_field()`, `sanitize_email()`, `sanitize_textarea_field()`, `wp_kses_post()` as appropriate.
- **Nonces for every form / AJAX action**: create with `wp_create_nonce()` / `wp_nonce_field()`, verify with `check_ajax_referer()` / `wp_verify_nonce()`. The `sculptureTheme.nonce` is already localized — use it.
- **Queries**: use `WP_Query` / `get_posts()` with explicit args; never raw SQL. If a custom query is unavoidable, use `$wpdb->prepare()`. Reset with `wp_reset_postdata()` after custom loops.
- **i18n**: wrap all user-facing strings in `__()` / `_e()` / `esc_html__()` with the `'sculpture-theme'` text domain.
- **No DB or option writes on the front-end render path.** Cache expensive work with transients.
- Document functions with a short DocBlock (`@param` / `@return`), matching the existing style.

## Enqueueing Assets (follow the existing pattern)

- Register all CSS/JS in `inc/enqueue.php` only.
- **Conditional loading**: page-specific CSS loads behind `is_singular()` / `is_post_type_archive()` / `is_front_page()` checks — keep that pattern; don't load everything everywhere.
- **Cache-busting**: use `filemtime()` as the version arg (as the CSS does). Apply the same to JS instead of the static version constant, so changes bust the cache during development.
- Declare dependencies explicitly (component styles depend on `sculpture-base`; scripts on `jquery` where needed).
- Load scripts in the footer (`true`) unless they must run earlier.

## JavaScript

- Current scripts are **jQuery-based** and wrapped in an IIFE with `'use strict'` (`(function($){ ... })(jQuery)`). Match this in existing files; prefer vanilla JS for genuinely new, standalone scripts.
- No `var` — use `const`/`let`. Descriptive names; no cryptic shorthands.
- **No inline styles from JS** — toggle a CSS class instead of writing to `.style` / jQuery `.css()` (e.g. replace `galleryImages.css('cursor','pointer')` with a class).
- **Clean up**: remove event listeners, clear timers/intervals, and debounce/throttle frequent handlers (resize, scroll) — the resize handler already debounces; keep that.
- Never trust or inject unescaped server data into the DOM. Pass data from PHP via `wp_localize_script()` (already set up as `sculptureTheme`).
- Guard against missing elements (early `return` when a selector finds nothing), as the gallery code does.

## CSS

- Match the existing structure: `base.css`, `components/*.css`, `pages/*.css`, `responsive/mobile.css`. Add new component styles as their own file and enqueue it.
- **No inline `style` attributes** in templates or via JS — use classes.
- Use responsive units (`rem`, `em`, `%`, `clamp()`); reserve `px` for borders and small fixed details.
- Use a consistent class-naming convention (BEM for custom classes); reuse existing classes before writing new ones.
- Don't hardcode values that already exist as variables/tokens; keep spacing on a consistent scale.

## Astra Integration

- This is a child theme — extend Astra via hooks/filters; don't duplicate parent markup unless necessary.
- The `sculpture_kill_astra()` pattern (removing Astra actions + layout filters on `is_singular('sculpture')`) is intentional for full-bleed sculpture pages. Reuse this approach for other CPTs that need a custom canvas rather than fighting Astra's CSS.

## Quality & Verification

- After PHP changes, check for errors (`php -l` on changed files) and confirm no notices/warnings with `WP_DEBUG` on.
- Verify output escaping and nonce checks are present on anything touching user input or front-end output.
- Keep formatting consistent with Prettier (`.prettierrc` uses the PHP plugin) — run it on changed files; don't reformat untouched ones.
- For multi-step tasks, state a brief plan with a verification check per step.

## Notes

- Inline code comments may be in Bulgarian — preserve the language of existing comments when editing nearby.
- Sublime project/workspace files and `.git` are in the theme folder; ignore them when reasoning about theme code.
