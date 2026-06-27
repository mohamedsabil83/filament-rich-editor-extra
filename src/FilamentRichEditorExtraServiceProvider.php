<?php

namespace MohamedSabil83\FilamentRichEditorExtra;

use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\EmojiPlugin;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\FullscreenPlugin;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\StickyToolbarPlugin;
use MohamedSabil83\FilamentRichEditorExtra\Plugins\TextDirectionPlugin;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentRichEditorExtraServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-rich-editor-extra')
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command->askToStarRepoOnGitHub('mohamedsabil83/filament-rich-editor-extra');
            });
    }

    public function bootingPackage(): void
    {
        FilamentAsset::register([
            Js::make('filament-rich-editor-extra/text-direction', __DIR__.'/../resources/js/dist/filament/filament-rich-editor-extra/TextDirection.js')->loadedOnRequest(),
            Js::make('filament-rich-editor-extra/emoji', __DIR__.'/../resources/js/dist/filament/filament-rich-editor-extra/Emoji.js')->loadedOnRequest(),
            Js::make('filament-rich-editor-extra/fullscreen', __DIR__.'/../resources/js/dist/filament/filament-rich-editor-extra/Fullscreen.js')->loadedOnRequest(),
            Js::make('filament-rich-editor-extra/sticky-toolbar', __DIR__.'/../resources/js/dist/filament/filament-rich-editor-extra/StickyToolbar.js')->loadedOnRequest(),
        ]);

        RichEditor::configureUsing(function (RichEditor $richEditor) {
            $richEditor->plugins([
                TextDirectionPlugin::make(),
                EmojiPlugin::make(),
                FullscreenPlugin::make(),
                StickyToolbarPlugin::make(),
            ]);
        });

        // Opt an editor's toolbar into sticky positioning. This marks the
        // editor wrapper with a `data-sticky-toolbar` attribute; the matching
        // CSS (injected by the StickyToolbar JS extension) does the rest.
        //
        // Filament rebinds the macro closure's `$this` to the RichEditor at call
        // time, but PHPStan can't model its custom Macroable trait and sees the
        // provider instead — hence the ignores on the editor method calls.
        RichEditor::macro('stickyToolbar', function (bool|Closure $condition = true): RichEditor {
            // @phpstan-ignore-next-line method.notFound
            return $this->extraAttributes(
                // @phpstan-ignore-next-line method.notFound
                fn (): array => $this->evaluate($condition) ? ['data-sticky-toolbar' => 'true'] : [],
                merge: true,
            );
        });
    }
}
