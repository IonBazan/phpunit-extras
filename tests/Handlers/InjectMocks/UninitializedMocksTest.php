<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Target;
use IonBazan\PHPUnitExtras\Tests\Handlers\Mock\MockHandlerTestCase;

class UninitializedMocksTest extends MockHandlerTestCase
{
    #[InjectMocks]
    private Target $subject;

    private Service $service;

    public function testUninitializedMockCannotBeInjected(): void
    {
        $this->apply();

        $this->assertFalse(isset($this->subject));
    }
}
