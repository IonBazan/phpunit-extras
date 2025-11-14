<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Handlers;

use IonBazan\PHPUnitExtras\Attributes\Captor;
use IonBazan\PHPUnitExtras\Helpers\ArgumentCaptor;
use IonBazan\PHPUnitExtras\Helpers\AttributeHelper;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

final class CaptorHandler implements Handler
{
    public function handle(TestCase $test, ReflectionClass $reflection): void
    {
        foreach (AttributeHelper::findPropertiesWithAttribute($reflection, Captor::class) as $property) {
            $this->handleProperty($test, $property);
        }
    }

    public function handleProperty(TestCase $test, ReflectionProperty $property): void
    {
        if ($property->isInitialized($test)) {
            return;
        }

        $property->setValue($test, new ArgumentCaptor());
    }
}
