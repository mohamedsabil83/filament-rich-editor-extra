<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Plugins;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;
use Tiptap\Core\Extension;

class EmojiPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Emojis are inserted as plain Unicode text, so there is no custom node to mirror
     * on the server — the character round-trips through tiptap-php untouched.
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
            FilamentAsset::getScriptSrc('filament-rich-editor-extra/emoji'),
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('emoji')
                ->label(__('Emoji'))
                ->jsHandler('$getEditor()?.chain().focus().openEmojiPicker($event.currentTarget).run()')
                ->icon(Heroicon::OutlinedFaceSmile),
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
