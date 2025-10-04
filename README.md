# A set of extra extensions for Filament RichEditor

<img src="art/cover-filament-rich-editor-extra.png" alt="Filament RichEditor Extra" />

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mohamedsabil83/filament-rich-editor-extra.svg?style=flat-square)](https://packagist.org/packages/mohamedsabil83/filament-rich-editor-extra)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mohamedsabil83/filament-rich-editor-extra/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mohamedsabil83/filament-rich-editor-extra/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mohamedsabil83/filament-rich-editor-extra/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mohamedsabil83/filament-rich-editor-extra/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mohamedsabil83/filament-rich-editor-extra.svg?style=flat-square)](https://packagist.org/packages/mohamedsabil83/filament-rich-editor-extra)

Extra goodies for the Filament Forms RichEditor (v4). This package ships small, focused extensions that plug straight into your existing editor.

### Currently included:
- Text direction (LTR / RTL).
- More to come...

## Requirements

| Package Version | PHP Version | Laravel Version | Filament Forms Version |
|:---------------:|:-----------:|:---------------:|:----------------------:|
|       1.x       |    8.2+     |       11+       |          4.x           |

## Installation

You can install the package via composer:

```bash
composer require mohamedsabil83/filament-rich-editor-extra
```

Then run the package installer:

```bash
php artisan filament-rich-editor-extra:install
```

## Usage

Once installed, all tools will be available for all RichEditor instances. The plugin registers itself automatically, so no additional configuration is required.

### Text Direction

You’ll see two new toolbar buttons: LTR and RTL.

Example:

```php
use Filament\Forms\Components\RichEditor;

RichEditor::make('content')
    ->label('Content')
    ->toolbarButtons([
        'rtl', 'ltr',
    ]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [MohamedSabil83](https://github.com/mohamedsabil83)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
