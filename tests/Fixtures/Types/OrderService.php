<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Fixtures\Types;

class OrderService
{
    public function __construct(private Logger $logger, private Payment $payment)
    {
    }

    public function place(int $amount): void
    {
        $this->payment->charge($amount);
        $this->logger->log("Charged $amount");
    }
}
