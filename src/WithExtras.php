<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras;

use IonBazan\PHPUnitExtras\Handlers\CaptorHandler;
use IonBazan\PHPUnitExtras\Handlers\InjectMocksHandler;
use IonBazan\PHPUnitExtras\Handlers\MockHandler;
use PHPUnit\Framework\Attributes\Before;
use ReflectionClass;

trait WithExtras
{
    #[Before]
    protected function setUpWithExtras(): void
    {
        $handlers = [
            new MockHandler(),
            new InjectMocksHandler(),
            new CaptorHandler(),
        ];
        $reflection = new ReflectionClass($this);

        foreach ($handlers as $handler) {
            $handler->handle($this, $reflection);
        }
    }
}
