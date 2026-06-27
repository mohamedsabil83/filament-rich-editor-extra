<?php

use Filament\Forms\Components\RichEditor;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\StickyToolbarPlugin;

it('does not expose a toolbar tool (it is enabled via the stickyToolbar method)', function () {
    expect(StickyToolbarPlugin::make()->getEditorTools())->toBe([]);
});

it('registers the sticky toolbar js extension asset', function () {
    expect(StickyToolbarPlugin::make()->getTipTapJsExtensions())->toHaveCount(1);
});

it('does not register a server-side php extension or editor action', function () {
    $plugin = StickyToolbarPlugin::make();

    expect($plugin->getTipTapPhpExtensions())->toBe([])
        ->and($plugin->getEditorActions())->toBe([]);
});

it('marks the editor wrapper with a data attribute when stickyToolbar() is called', function () {
    $editor = RichEditor::make('content')->stickyToolbar();

    expect($editor->getExtraAttributes())->toHaveKey('data-sticky-toolbar');
});

it('does not mark the wrapper when stickyToolbar() is disabled by condition', function () {
    $editor = RichEditor::make('content')->stickyToolbar(false);

    expect($editor->getExtraAttributes())->not->toHaveKey('data-sticky-toolbar');
});

it('evaluates a closure condition passed to stickyToolbar()', function () {
    $enabled = RichEditor::make('content')->stickyToolbar(fn (): bool => true);
    $disabled = RichEditor::make('content')->stickyToolbar(fn (): bool => false);

    expect($enabled->getExtraAttributes())->toHaveKey('data-sticky-toolbar')
        ->and($disabled->getExtraAttributes())->not->toHaveKey('data-sticky-toolbar');
});
