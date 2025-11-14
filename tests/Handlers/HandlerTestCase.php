<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers;

use IonBazan\PHPUnitExtras\Handlers\Handler;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Base test case for testing individual handlers.
 */
abstract class HandlerTestCase extends TestCase
{
    protected function apply(): void
    {
        $this->getHandler()->handle($this, new ReflectionClass($this));
    }

    abstract protected function getHandler(): Handler;
}
