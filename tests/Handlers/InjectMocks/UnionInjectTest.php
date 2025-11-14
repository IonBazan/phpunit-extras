<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Target;
use PHPUnit\Framework\MockObject\MockObject;
use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;

class UnionInjectTest extends InjectMocksHandlerTestCase
{
    private Service|MockObject $service;
    #[InjectMocks]
    private Target $subject;

    public function testUnionMock(): void
    {
        $this->service = $this->createMock(Service::class);

        $this->apply();

        $this->assertInstanceOf(Target::class, $this->subject);
    }
}
