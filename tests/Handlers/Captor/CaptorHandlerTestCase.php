<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Handlers\CaptorHandler;
use IonBazan\PHPUnitExtras\Handlers\Handler;
use IonBazan\PHPUnitExtras\Tests\Handlers\HandlerTestCase;

abstract class CaptorHandlerTestCase extends HandlerTestCase
{
    protected function getHandler(): Handler
    {
        return new CaptorHandler();
    }
}
