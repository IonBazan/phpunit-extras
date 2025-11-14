<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;

class SkippedPropertiesTest extends MockHandlerTestCase
{
    private Service $noAttribute;

    #[Mock]
    private bool $basicType;

    #[Mock]
    private MockObject|null $notMockable;

    public function testSkippedProperties(): void
    {
        $this->apply();

        $this->assertFalse(isset($this->invalidType));
        $this->assertFalse(isset($this->noAttribute));
        $this->assertFalse(isset($this->notMockable));
    }
}
