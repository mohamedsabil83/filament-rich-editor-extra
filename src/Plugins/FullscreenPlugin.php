<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Plugins;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;
use Tiptap\Core\Extension;

class FullscreenPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Fullscreen is a purely client-side, UI-only feature — it toggles a class
     * on the editor wrapper and saves no content, so there is no node to mirror
     * on the server.
     *
     * @return array<Extension>
     */
    public function getTipTapPhpExtensions(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc('filament-rich-editor-extra/fullscreen'),
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('fullscreen')
                ->label(__('Fullscreen'))
                ->jsHandler('$getEditor()?.chain().focus().toggleFullscreen().run()')
                ->activeJsExpression('$getEditor()?.storage.customFullscreen?.active')
                ->icon(Heroicon::OutlinedArrowsPointingOut),
        ];
    }

    /**
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [];
    }
}
