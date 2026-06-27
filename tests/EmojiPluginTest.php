<?php

use Filament\Forms\Components\RichEditor\RichEditorTool;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\EmojiPlugin;

it('exposes an emoji toolbar tool that opens the picker', function () {
    $tools = EmojiPlugin::make()->getEditorTools();

    expect($tools)->toHaveCount(1)
        ->and($tools[0])->toBeInstanceOf(RichEditorTool::class)
        ->and($tools[0]->getName())->toBe('emoji')
        ->and($tools[0]->getJsHandler())->toContain('openEmojiPicker');
});

it('registers the emoji js extension asset', function () {
    expect(EmojiPlugin::make()->getTipTapJsExtensions())->toHaveCount(1);
});

it('does not register a server-side php extension or editor action', function () {
    $plugin = EmojiPlugin::make();

    expect($plugin->getTipTapPhpExtensions())->toBe([])
        ->and($plugin->getEditorActions())->toBe([]);
});
