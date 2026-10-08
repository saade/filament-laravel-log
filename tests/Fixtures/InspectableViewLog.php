<?php

namespace Saade\FilamentLaravelLog\Tests\Fixtures;

use Saade\FilamentLaravelLog\Pages\ViewLog;

class InspectableViewLog extends ViewLog
{
    /**
     * @return array<string, string>
     */
    public function listedFiles(): array
    {
        return $this->getFileNames($this->getFinder())->all();
    }
}
