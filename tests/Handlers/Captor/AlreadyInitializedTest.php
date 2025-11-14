<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;

class AlreadyInitializedTest extends CaptorHandlerTestCase
{
    #[Captor]
    private ArgumentCaptor $captor;

    public function testPreservesUserCaptor(): void
    {
        $oldCaptor = $this->captor = new ArgumentCaptor();

        $this->apply();

        $this->assertSame($oldCaptor, $this->captor);
    }
}
