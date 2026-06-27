<?php

use Filament\Forms\Components\RichEditor\RichEditorTool;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\FullscreenPlugin;

it('exposes a fullscreen toolbar tool that toggles fullscreen', function () {
    $tools = FullscreenPlugin::make()->getEditorTools();

    expect($tools)->toHaveCount(1)
        ->and($tools[0])->toBeInstanceOf(RichEditorTool::class)
        ->and($tools[0]->getName())->toBe('fullscreen')
        ->and($tools[0]->getJsHandler())->toContain('toggleFullscreen');
});

it('registers the fullscreen js extension asset', function () {
    expect(FullscreenPlugin::make()->getTipTapJsExtensions())->toHaveCount(1);
});

it('does not register a server-side php extension or editor action', function () {
    $plugin = FullscreenPlugin::make();

    expect($plugin->getTipTapPhpExtensions())->toBe([])
        ->and($plugin->getEditorActions())->toBe([]);
});
