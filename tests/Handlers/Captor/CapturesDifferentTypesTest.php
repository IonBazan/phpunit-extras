<?php
// tests/Handlers/Captor/CapturesDifferentTypesTest.php
declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\Captor;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use PHPUnit\Framework\MockObject\MockObject;

class CapturesDifferentTypesTest extends CaptorHandlerTestCase
{
    private Logger&MockObject $logger;
    #[Captor]
    private ArgumentCaptor $stringCaptor;
    #[Captor]
    private ArgumentCaptor $intCaptor;

    public function testCapturesDifferentTypes(): void
    {
        $this->logger = $this->createMock(Logger::class);
        $this->apply();

        $this->logger->expects($this->once())->method('log')->with($this->stringCaptor);
        $this->logger->expects($this->once())->method('logInt')->with($this->intCaptor);


        $this->logger->log('hello');
        $this->logger->logInt(42);

        $this->assertSame('hello', $this->stringCaptor->getValue());
        $this->assertSame(42, $this->intCaptor->getValue());
    }
}
