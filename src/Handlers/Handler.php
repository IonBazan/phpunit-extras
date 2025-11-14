<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Handlers;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

interface Handler
{
    public function handle(TestCase $test, ReflectionClass $reflection): void;
}
