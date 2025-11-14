<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Feature;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\WithExtras;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\OrderService;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Payment;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExtrasTest extends TestCase
{
    use WithExtras;

    #[Mock]
    private Logger&MockObject $logger;
    #[Mock]
    private Payment&MockObject $payment;
    #[InjectMocks]
    private OrderService $service;
    #[Captor]
    private ArgumentCaptor $captor;

    protected function setUp(): void
    {
        parent::setUp();

        // Test it in setUp to ensure they are already set before this
        $this->assertInstanceOf(MockObject::class, $this->logger);
        $this->assertInstanceOf(Logger::class, $this->logger);
        $this->assertInstanceOf(MockObject::class, $this->payment);
        $this->assertInstanceOf(Payment::class, $this->payment);
        $this->assertInstanceOf(ArgumentCaptor::class, $this->captor);
    }

    public function testOrderIsPlaced(): void
    {
        $this->payment->expects($this->once())->method('charge')->with(100);
        $this->logger->expects($this->once())->method('log')->with($this->captor);

        $this->service->place(100);
        $this->assertSame(['Charged 100'], $this->captor->getAllValues());
    }
}
