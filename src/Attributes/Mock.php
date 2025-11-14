<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Mock
{
    public function __construct(public bool $lenient = false)
    {
    }
}
