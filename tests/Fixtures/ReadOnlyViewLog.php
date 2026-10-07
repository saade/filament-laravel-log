<?php

namespace Saade\FilamentLaravelLog\Tests\Fixtures;

use Closure;
use Saade\FilamentLaravelLog\Pages\ViewLog;

class ReadOnlyViewLog extends ViewLog
{
    protected bool | Closure $isClearable = false;
}
