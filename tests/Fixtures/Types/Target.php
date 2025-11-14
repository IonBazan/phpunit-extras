<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Fixtures\Types;

class Target
{
    public function __construct(public readonly Service $service, public readonly bool $optional = true)
    {
    }

    public function execute()
    {
        return $this->service->run();
    }
}
