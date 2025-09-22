<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MohamedSabil83\FilamentRichEditorExtra\FilamentRichEditorExtra
 */
class FilamentRichEditorExtra extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MohamedSabil83\FilamentRichEditorExtra\FilamentRichEditorExtra::class;
    }
}
