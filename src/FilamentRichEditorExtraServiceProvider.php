<?php

namespace MohamedSabil83\FilamentRichEditorExtra;

use Filament\Forms\Components\RichEditor;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
        ]);

        RichEditor::configureUsing(function (RichEditor $richEditor) {
            $richEditor->plugins([
                TextDirectionPlugin::make(),
            ]);
        });
    }
}
