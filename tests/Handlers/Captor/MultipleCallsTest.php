<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use PHPUnit\Framework\MockObject\MockObject;

class MultipleCallsTest extends CaptorHandlerTestCase
{
    private Logger&MockObject $logger;
    #[Captor]
    private ArgumentCaptor $captor;

    public function testCapturesMultipleCalls(): void
    {
        $this->logger = $this->createMock(Logger::class);
        $this->apply();

        $this->logger->expects($this->exactly(3))
            ->method('log')
            ->with($this->captor);

        $this->logger->log('first');
        $this->logger->log('second');
        $this->logger->log('third');

        $this->assertSame('third', $this->captor->getLastValue());
        $this->assertSame(['first', 'second', 'third'], $this->captor->getAllValues());
        $this->assertSame(3, $this->captor->count());
        $this->captor->reset();
        $this->assertSame(0, $this->captor->count());
    }
}
