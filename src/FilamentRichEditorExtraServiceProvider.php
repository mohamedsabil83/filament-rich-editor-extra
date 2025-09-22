<?php

namespace MohamedSabil83\FilamentRichEditorExtra;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MohamedSabil83\FilamentRichEditorExtra\Commands\FilamentRichEditorExtraCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament_rich_editor_extra_table')
            ->hasCommand(FilamentRichEditorExtraCommand::class);
    }
}
