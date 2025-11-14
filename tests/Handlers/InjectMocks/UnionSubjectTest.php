<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Target;
use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;

class UnionSubjectTest extends InjectMocksHandlerTestCase
{
    private Service $service;
    #[InjectMocks]
    private Target|bool|null $subject;

    public function testUnionSubject(): void
    {
        $this->service = $this->createMock(Service::class);

        $this->apply();

        $this->assertInstanceOf(Target::class, $this->subject);
    }
}
