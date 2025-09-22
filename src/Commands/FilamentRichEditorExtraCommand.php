<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Commands;

use Illuminate\Console\Command;

class FilamentRichEditorExtraCommand extends Command
{
    public $signature = 'filament-rich-editor-extra';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
