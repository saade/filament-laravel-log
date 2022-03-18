# Access laravel log through Filament admin panel

![Log Viewer](./art/preview.jpeg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/saade/filament-laravel-log/run-tests?label=tests)](https://github.com/saade/filament-laravel-log/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/saade/filament-laravel-log/Check%20&%20fix%20styling?label=code%20style)](https://github.com/saade/filament-laravel-log/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)

# Features

- Jump between start and end of file
- Refresh content
- Clear logs

### Upcoming
- Support multiple log files

<br>

## Support Filament

<a href="https://github.com/sponsors/danharrin">
<img width="320" alt="filament-logo" src="https://filamentadmin.com/images/sponsor-banner.jpg">
</a>

<br>

## Installation

You can install the package via composer:

```bash
composer require saade/filament-laravel-log
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-laravel-log-config"
```

This is the contents of the published config file:

```php
/**
 * The log file to be read.
 */
'logFile' => storage_path('logs/laravel.log'),

/**
 * Navigation group.
 */
'navigationGroup' => 'System',

/**
 * Navigation icon.
 */
'navigationIcon' => 'heroicon-o-document-text',

/**
 * Navigation label.
 */
'navigationLabel' => 'Logs',

/**
 * Navigation slug.
 */
'slug' => 'system-logs',

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
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-laravel-log-views"
```

## Usage

Just install the package and you're ready to go!

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Saade](https://github.com/saade)
- [Laravel Forge](https://forge.laravel.com) - for the editor theme
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
