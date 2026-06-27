<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Plugins;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Tiptap\Core\Extension;

class StickyToolbarPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Sticky Toolbar is a purely client-side, UI-only feature — it adds a
     * `position: sticky` rule to the editor toolbar and saves no content, so
     * there is no node to mirror on the server.
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
            FilamentAsset::getScriptSrc('filament-rich-editor-extra/sticky-toolbar'),
        ];
    }

    /**
     * Sticky Toolbar is not a toolbar button — it is enabled per editor with
     * the `->stickyToolbar()` method (registered as a macro on `RichEditor`),
     * so no tools are exposed here.
     *
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [];
    }

    /**
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [];
    }
}
