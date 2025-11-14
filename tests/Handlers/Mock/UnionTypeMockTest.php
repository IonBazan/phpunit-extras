<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Tests\AbstractFixtureTest;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;

class UnionTypeMockTest extends MockHandlerTestCase
{
    #[Mock]
    private Service|MockObject|null $service;

    public function testUnionType(): void
    {
        $this->apply();

        $this->assertInstanceOf(MockObject::class, $this->service);
        $this->assertInstanceOf(Service::class, $this->service);
        $this->assertNotNull($this->service);
    }
}
