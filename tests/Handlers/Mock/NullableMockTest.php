<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Attributes\Stub;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub as StubObject;

class NullableMockTest extends MockHandlerTestCase
{
    #[Mock]
    private ?Service $service;
    #[Stub]
    private ?Service $stub;

    public function testNullable(): void
    {
        $this->apply();
        $this->assertNotNull($this->service);
        $this->assertInstanceOf(MockObject::class, $this->service);
        $this->assertInstanceOf(StubObject::class, $this->stub);
    }
}
