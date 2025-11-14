<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Handlers\Handler;
use IonBazan\PHPUnitExtras\Handlers\MockHandler;
use IonBazan\PHPUnitExtras\Tests\Handlers\HandlerTestCase;

abstract class MockHandlerTestCase extends HandlerTestCase
{
    protected function getHandler(): Handler
    {
        return new MockHandler();
    }
}
