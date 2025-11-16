<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Mock;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Attributes\Stub;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Service;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub as StubObject;

class SkippedPropertiesTest extends MockHandlerTestCase
{
    private Service $noAttribute;
    #[Mock]
    private bool $basicType;
    #[Mock]
    private MockObject|null $notMockable;
    #[Stub]
    private StubObject|null $notStubbable;

    public function testSkippedProperties(): void
    {
        $this->apply();

        $this->assertFalse(isset($this->invalidType));
        $this->assertFalse(isset($this->noAttribute));
        $this->assertFalse(isset($this->notMockable));
        $this->assertFalse(isset($this->notStubbable));
    }
}
