<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Attributes\Stub;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub as StubObject;

class AlreadyInitializedMockTest extends MockHandlerTestCase
{
    #[Mock]
    private Service $service;
    #[Stub]
    private Service $stub;

    public function testAlreadyInitialized(): void
    {
        $this->service = $this->createMock(Service::class);
        $this->service->method('run')->willReturn('manual');

        $this->stub = $this->createStub(Service::class);
        $this->stub->method('run')->willReturn('manualStub');

        $this->apply();

        $this->assertInstanceOf(MockObject::class, $this->service);
        $this->assertSame('manual', $this->service->run());

        $this->assertInstanceOf(StubObject::class, $this->stub);
        $this->assertSame('manualStub', $this->stub->run());
    }
}
