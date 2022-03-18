<?php

namespace Saade\FilamentLaravelLog\Commands;

use Illuminate\Console\Command;

class UpgradeFilamentLaravelLogCommand extends Command
{
    public $signature = 'filament-laravel-log:upgrade';

    public $description = 'Upgrade filament-laravel-log to the latest version';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
