<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use PHPUnit\Framework\MockObject\MockObject;

class NoCallsTest extends CaptorHandlerTestCase
{
    private Logger&MockObject $logger;
    #[Captor]
    private ArgumentCaptor $captor;

    public function testNoCallsReturnsNull(): void
    {
        $this->logger = $this->createMock(Logger::class);
        $this->apply();

        $this->logger->expects($this->never())->method('log');

        $this->assertNull($this->captor->getValue());
        $this->assertSame([], $this->captor->getAllValues());
        $this->assertSame(0, $this->captor->count());
    }
}
