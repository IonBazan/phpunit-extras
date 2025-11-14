<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Handlers\InjectMocks;

use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Logger;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\OrderService;
use IonBazan\PHPUnitExtras\Tests\Fixtures\Types\Payment;

class BasicInjectMocksTest extends InjectMocksHandlerTestCase
{
    private Payment $payment;
    private Logger $logger;
    #[InjectMocks]
    private OrderService $service;

    public function testBasicInjectMocks(): void
    {
        $this->payment = $this->createMock(Payment::class);
        $this->logger = $this->createMock(Logger::class);

        $this->apply();
        $this->assertInstanceOf(OrderService::class, $this->service);

        $this->payment->expects($this->once())->method('charge')->with(100);
        $this->logger->expects($this->once())->method('log')->with('Charged 100');

        $this->service->place(100);
    }
}
