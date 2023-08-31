# Filament Laravel Log

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)
[![Total Downloads](https://img.shields.io/packagist/dt/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)

<p align="center">
    <img src="https://raw.githubusercontent.com/saade/filament-laravel-log/3.x/art/cover1.png" alt="Banner" style="width: 100%; max-width: 800px; border-radius: 10px" />
</p>

# Features

- Syntax highlighting
- Light/ Dark mode
- Quickly jump between start and end of the file
- Refresh log contents
- Clear log contents
- Search multiple files in multiple directories
- Ignored file patterns

<br>

## Installation

You can install the package via composer:

```bash
composer require saade/filament-laravel-log:^3.0
```

## Usage

Add the `Saade\FilamentLaravelLog\FilamentLaravelLogPlugin` to your panel config.

```php
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(
                FilamentLaravelLogPlugin::make()
            );
    }
}
```

## Configuration

### Customizing the navigation item

```php
FilamentLaravelLogPlugin::make()
    ->navigationGroup('System Tools')
    ->navigationLabel('Logs')
    ->navigationIcon('heroicon-o-bug-ant')
    ->navigationSort(1)
    ->slug('logs')
```

### Customizing the log search

```php
FilamentLaravelLogPlugin::make()
  ->logDirs([
      storage_path('logs'),     // The default value
  ])
  ->excludedFilesPatterns([
      '*2023*'
  ])
```

### Authorization
If you would like to prevent certain users from accessing the logs page, you should add a `authorize` callback in the FilamentLaravelLogPlugin chain.
Customizing the editor's appearance

Publish the config file:

```bash
php artisan vendor:publish --tag="log-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /**
     * Maximum amount of lines that editor will render.
     */
    'maxLines' => 50,

    /**
     * Minimum amount of lines that editor will render.
     */
    'minLines' => 10,

    /**
     * Editor font size.
     */
    'fontSize' => 12
];
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Saade](https://github.com/saade)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<p align="center">
    <a href="https://github.com/sponsors/saade">
        <img src="https://raw.githubusercontent.com/saade/filament-laravel-log/3.x/art/sponsor.png" alt="Sponsor Saade" style="width: 100%; max-width: 800px;" />
    </a>
</p>
