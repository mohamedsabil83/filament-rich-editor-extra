<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Plugins;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;
use MohamedSabil83\FilamentRichEditorExtra\Extensions\TextDirection;
use Tiptap\Core\Extension;

class TextDirectionPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Return PHP TipTap extensions (if any). For direction, you may want to use a mark or attribute extension.
     *
     * @return array<Extension>
     */
    public function getTipTapPhpExtensions(): array
    {
        // This method should return an array of PHP TipTap extension objects.
        // See: https://github.com/ueberdosis/tiptap-php

        return [
            app(TextDirection::class),
        ];
    }

    /**
     * Return JS extension files (URLs) for TipTap in JS.
     *
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc('filament-rich-editor-extra/text-direction'),
        ];
    }

    /**
     * Return tools (buttons) for the Editor’s toolbar.
     *
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('ltr')
                ->label(__('LTR'))
                ->jsHandler('$getEditor()?.chain().focus().setTextDirection(\'ltr\').run()')
                ->activeJsExpression('$getEditor()?.isActive(\'paragraph\', { dir: \'ltr\' }) || $getEditor()?.isActive(\'heading\', { dir: \'ltr\' })')
                ->icon(Heroicon::ArrowLeft),
            RichEditorTool::make('rtl')
                ->label(__('RTL'))
                ->jsHandler('$getEditor()?.chain().focus().setTextDirection(\'rtl\').run()')
                ->activeJsExpression('$getEditor()?.isActive(\'paragraph\', { dir: \'rtl\' }) || $getEditor()?.isActive(\'heading\', { dir: \'rtl\' })')
                ->icon(Heroicon::ArrowRight),
        ];
    }

    /**
     * Return actions for the editor. If the tools need actions etc.
     *
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [];
    }
}
