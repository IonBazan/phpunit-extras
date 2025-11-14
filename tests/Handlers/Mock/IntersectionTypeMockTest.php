<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;

class IntersectionTypeMockTest extends MockHandlerTestCase
{
    #[Mock]
    private Service&MockObject $service;

    public function testIntersectionType(): void
    {
        $this->apply();
        $this->assertInstanceOf(MockObject::class, $this->service);
        $this->assertInstanceOf(Service::class, $this->service);
    }
}
