<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use PHPUnit\Framework\MockObject\MockObject;

class BasicCaptureTest extends CaptorHandlerTestCase
{
    private Logger&MockObject $logger;
    #[Captor]
    private ArgumentCaptor $captor;

    public function testCapturesStringArgument(): void
    {
        $this->logger = $this->createMock(Logger::class);
        $this->apply();

        $this->logger->expects($this->once())
            ->method('log')
            ->with($this->captor);

        $this->logger->log('error message');

        $this->assertSame('error message', $this->captor->getValue());
        $this->assertSame(['error message'], $this->captor->getAllValues());
    }
}
