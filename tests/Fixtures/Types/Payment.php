<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Fixtures\Types;

interface Payment
{
    public function charge(int $amount): void;
}
