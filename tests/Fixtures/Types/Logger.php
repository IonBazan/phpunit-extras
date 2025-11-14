<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Fixtures\Types;

interface Logger
{
    public function log(string $msg): void;
    public function logInt(int $int): void;
}
