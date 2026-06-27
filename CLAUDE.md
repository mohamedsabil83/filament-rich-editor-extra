# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel/Filament package that adds extra tools to the Filament v4 Forms `RichEditor` (which is built on Tiptap). Currently ships one extension: **Text Direction** (LTR/RTL toolbar buttons). It is a library/package — there is no host app; it is exercised via Orchestra Testbench.

## Commands

- `composer test` — run the Pest test suite
- `composer test-coverage` — tests with coverage
- `vendor/bin/pest tests/ArchTest.php` — run a single test file; append `--filter="name"` to target one test
- `composer analyse` — PHPStan (larastan) at level 5 over `src/`
- `composer format` — Laravel Pint (laravel preset, no `pint.json`)
- `npm run build` — bundle the JS extension(s) with esbuild (see JS build below)

CI mirrors these: `run-tests.yml`, `phpstan.yml`, `fix-php-code-style-issues.yml`.

## Architecture

Each editor feature is a **plugin** wiring three layers together. To add a feature, replicate the Text Direction pattern across all three:

1. **PHP Tiptap extension** (`src/Extensions/`) — extends `Tiptap\Core\Extension` (from the `ueberdosis/tiptap-php` lib, used server-side to parse/render rich content). Defines node attributes and types. This is the server-side mirror of the JS extension.

2. **JS Tiptap extension** (`resources/js/filament/.../*.js`) — the real client-side Tiptap extension, registering the node attributes via `parseHTML`/`renderHTML`. Prefer Tiptap's native/core features over hand-rolling: e.g. Text Direction relies on the `setTextDirection`/`unsetTextDirection` commands built into `@tiptap/core` (always registered by the editor as the core `textDirection` extension) and only adds the `dir` global attribute the core extension omits unless a global direction is configured. **The PHP extension in (1) must mirror the attribute/type definitions here** so server-rendered HTML matches what the editor produces. Note `tiptap-php` has no native text-direction equivalent, so the PHP side stays a custom extension.

3. **Plugin** (`src/Plugins/`) — implements Filament's `RichContentPlugin` contract, gluing 1 and 2 together. Its methods:
   - `getTipTapPhpExtensions()` → the PHP extension instances
   - `getTipTapJsExtensions()` → asset script srcs via `FilamentAsset::getScriptSrc(...)`
   - `getEditorTools()` → toolbar buttons (`RichEditorTool`), each with a `jsHandler` calling the JS command (e.g. `setTextDirection('ltr')`) and an `activeJsExpression` for active state
   - `getEditorActions()` → optional Filament actions

The **service provider** (`FilamentRichEditorExtraServiceProvider`, Spatie package-tools based) registers everything globally: in `bootingPackage()` it registers each JS dist file as a `FilamentAsset::register([Js::make(...)->loadedOnRequest()])` and calls `RichEditor::configureUsing(...)` to attach the plugins to **every** RichEditor instance automatically. Users opt buttons into a specific editor via `->toolbarButtons(['rtl', 'ltr'])`.

## JS build (important)

The package loads JS from `resources/js/dist/...`, NOT the source under `resources/js/filament/...`. After editing any source JS you **must** run `npm run build` (esbuild, config in `bin/build.js`) to regenerate the bundled `dist` file, or the change won't take effect at runtime. Add new entry points to `bin/build.js`.

## Conventions

- PHP namespace root: `MohamedSabil83\FilamentRichEditorExtra\` → `src/`
- The arch test forbids `dd`, `dump`, and `ray` in committed code.
- Tiptap extension `name` (e.g. `customTextDirection`) and attribute/type lists must stay identical between the PHP and JS extensions.