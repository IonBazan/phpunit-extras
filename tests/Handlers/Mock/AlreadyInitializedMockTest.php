<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;

class AlreadyInitializedMockTest extends MockHandlerTestCase
{
    #[Mock]
    private Service $service;

    public function testAlreadyInitialized(): void
    {
        $this->service = $this->createMock(Service::class);
        $this->service->method('run')->willReturn('manual');

        $this->apply();

        $this->assertInstanceOf(MockObject::class, $this->service);
        $this->assertSame('manual', $this->service->run());
    }
}
