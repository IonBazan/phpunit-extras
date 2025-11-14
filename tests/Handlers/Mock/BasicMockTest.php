<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;

class BasicMockTest extends MockHandlerTestCase
{
    #[Mock]
    public Service $service;

    public function testBasicMock(): void
    {
        $this->apply();
        $this->assertInstanceOf(MockObject::class, $this->service);
    }
}
