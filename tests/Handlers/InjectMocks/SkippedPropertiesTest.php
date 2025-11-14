<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Target;
use IonBazan\PHPUnitExtras\Tests\Handlers\Mock\MockHandlerTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SkippedPropertiesTest extends MockHandlerTestCase
{
    #[InjectMocks]
    private Target $subject;

    #[InjectMocks]
    private bool $basicType;

    #[InjectMocks]
    private MockObject|null $notMockable;

    private static bool $staticProperty = true;

    public function testSkippedProperties(): void
    {
        $this->apply();

        $this->assertFalse(isset($this->invalidType));
        $this->assertFalse(isset($this->noAttribute));
        $this->assertFalse(isset($this->notMockable));
    }
}
