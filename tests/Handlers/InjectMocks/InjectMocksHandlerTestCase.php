<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Handlers\Handler;
use IonBazan\PHPUnitExtras\Handlers\InjectMocksHandler;
use IonBazan\PHPUnitExtras\Tests\Handlers\HandlerTestCase;

abstract class InjectMocksHandlerTestCase extends HandlerTestCase
{
    protected function getHandler(): Handler
    {
        return new InjectMocksHandler();
    }
}
