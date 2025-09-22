<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Tests;

use MohamedSabil83\FilamentRichEditorExtra\FilamentRichEditorExtraServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentRichEditorExtraServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app) {}
}
