# Filament Laravel Log

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)
[![Total Downloads](https://img.shields.io/packagist/dt/saade/filament-laravel-log.svg?style=flat-square)](https://packagist.org/packages/saade/filament-laravel-log)
[![Tests](https://img.shields.io/github/actions/workflow/status/saade/filament-laravel-log/run-tests.yml?branch=4.x&label=tests&style=flat-square)](https://github.com/saade/filament-laravel-log/actions/workflows/run-tests.yml)

<p align="center">
    <img src="https://raw.githubusercontent.com/saade/filament-laravel-log/4.x/art/cover1.png" alt="Banner" style="width: 100%; max-width: 800px; border-radius: 10px" />
</p>

A log viewer for [Filament](https://filamentphp.com): read your Laravel log files from a page of your panel.

# Features

- Syntax highlighting
- Light and dark mode
- Jump to the start or the end of the file
- Refresh the log contents
- Clear a log file
- Log files from several directories, found by name
- Ignored file patterns
- Compressed (`.gz`) log files
- Access restricted to the users you choose

# Version compatibility

| Plugin | Filament | Install |
| ------ | -------- | ------- |
| 4.x    | 4.x, 5.x | `composer require saade/filament-laravel-log:"^4.0"` |
| 3.x    | 3.x      | `composer require saade/filament-laravel-log:"^3.0"` |
| 1.x    | 2.x      | `composer require saade/filament-laravel-log:"^1.2"` |

## Installation

You can install the package via composer:

```bash
composer require saade/filament-laravel-log:"^4.0"
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/5.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file or your app's css file if using the standalone packages.

```css
@import '../../../../vendor/saade/filament-laravel-log/resources/css/filament-laravel-log.css';

@source '../../../../vendor/saade/filament-laravel-log/resources/views/**/*.blade.php';
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

### Customizing the navigation

```php
FilamentLaravelLogPlugin::make()
    ->navigationGroup('System')
    ->navigationParentItem('Tools')
    ->navigationLabel('Logs')
    ->navigationIcon('heroicon-o-bug-ant')
    ->activeNavigationIcon('heroicon-s-bug-ant')
    ->navigationBadge('+10')
    ->navigationBadgeColor('danger')
    ->navigationBadgeTooltip('New logs available')
    ->navigationSort(1)
    ->title('Application Logs')
    ->slug('logs')
```

### Choosing the log files

The page lists the files in `storage/logs`, including the ones in its subfolders. To read other directories, or to leave some files out:

```php
FilamentLaravelLogPlugin::make()
    ->logDirs([
        storage_path('logs'),     // The default value
        '/var/log/supervisor',
    ])
    ->excludedFilesPatterns([
        '*2023*',
    ])
```

Only the files the page lists can be opened or cleared. An excluded file cannot be reached by typing its path.

The file picker lists the 5 most recently changed files; type part of a name to find the others. Change that number with the `limit` key of the [config file](#customizing-the-editor-appearance).

### Authorization

> [!WARNING]
> By default, every user who can sign in to the panel can open the logs page, and clear the files. Logs often hold personal data, tokens and stack traces, so restrict it.

Add an `authorize` callback to the plugin. It has to return `true` for the user to get in:

```php
FilamentLaravelLogPlugin::make()
    ->authorize(
        fn (): bool => auth()->user()->isAdmin()
    )
```

With a gate or a permission, for example from [spatie/laravel-permission](https://github.com/spatie/laravel-permission):

```php
FilamentLaravelLogPlugin::make()
    ->authorize(
        fn (): bool => auth()->user()->can('view-logs')
    )
```

The callback must return a boolean. A truthy value such as `1` from an `is_admin` column is treated as no access, so cast it: `fn (): bool => (bool) auth()->user()->is_admin`.

Do not add the plugin to a panel your customers sign in to, such as a tenant panel, without an `authorize` callback: the log files are the whole application's, not one tenant's.

### Letting users read but not clear

Extend the page and turn clearing off, then tell the plugin to use it (see [Customizing the log page](#customizing-the-log-page)):

```php
use Closure;
use Saade\FilamentLaravelLog\Pages\ViewLog as BaseViewLog;

class ViewLog extends BaseViewLog
{
    protected bool | Closure $isClearable = false;
}
```

### Customizing the log page

To customize the log page, you can extend the `Saade\FilamentLaravelLog\Pages\ViewLog` page and override its methods.

```php
use Saade\FilamentLaravelLog\Pages\ViewLog as BaseViewLog;

class ViewLog extends BaseViewLog
{
    // Your implementation
}
```

```php
use App\Filament\Pages\ViewLog;

FilamentLaravelLogPlugin::make()
    ->viewLog(ViewLog::class)
```


### Customizing the editor appearance

Publish the config file:

```bash
php artisan vendor:publish --tag="log-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /**
     * The tallest the editor grows, in lines, before it scrolls. The whole
     * file is loaded whatever this is set to.
     */
    'maxLines' => 50,

    /**
     * The height of the editor, in lines, when the file is shorter.
     */
    'minLines' => 10,

    /**
     * Editor font size.
     */
    'fontSize' => 12,

    /**
     * How many files the file picker lists before you search. Searching by
     * name finds the rest.
     */
    'limit' => 5,
];
```

The whole file is sent to the browser, so a very large log can be slow to open or run out of memory. Rotate your logs, for example with Laravel's `daily` channel.

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
        <img src="https://raw.githubusercontent.com/saade/filament-laravel-log/4.x/art/sponsor.png" alt="Sponsor Saade" style="width: 100%; max-width: 800px;" />
    </a>
</p>
