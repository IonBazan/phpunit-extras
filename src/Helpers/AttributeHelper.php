<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use ReflectionClass;
use ReflectionProperty;

/**
 * @internal
 */
final class AttributeHelper
{
    /**
     * @template T of object
     * @param class-string<T> $attributeClass
     * @return ReflectionProperty[]
     */
    public static function findPropertiesWithAttribute(ReflectionClass $reflection, string $attributeClass): array
    {
        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            if ($property->getAttributes($attributeClass)) {
                $properties[] = $property;
            }
        }
        return $properties;
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClass
     * @return T|null
     */
    public static function getAttributeInstance(ReflectionProperty $property, string $attributeClass): ?object
    {
        $attributes = $property->getAttributes($attributeClass);

        return ($attributes[0] ?? null)?->newInstance();
    }
}
