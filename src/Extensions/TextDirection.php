<?php

namespace MohamedSabil83\FilamentRichEditorExtra\Extensions;

use Tiptap\Core\Extension;

class TextDirection extends Extension
{
    public static $name = 'customTextDirection';

    public function addOptions(): array
    {
        return [
            'types' => ['paragraph', 'heading'],
        ];
    }

    public function addGlobalAttributes(): array
    {
        return [
            [
                'types' => $this->options['types'],
                'attributes' => [
                    'dir' => [
                        'default' => null,
                        'parseHTML' => fn ($element) => $element->getAttribute('dir'),
                        // 'renderHTML' => fn ($attributes) => ['dir' => $attributes->dir],
                    ],
                ],
            ],
        ];
    }
}
