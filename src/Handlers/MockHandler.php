<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Handlers;

use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Helpers\AttributeHelper;
use IonBazan\PHPUnitExtras\Helpers\MockFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

final class MockHandler implements Handler
{
    public function handle(TestCase $test, ReflectionClass $reflection): void
    {
        foreach (AttributeHelper::findPropertiesWithAttribute($reflection, Mock::class) as $property) {
            $this->handleProperty($test, $property);
        }
    }

    public function handleProperty(TestCase $test, ReflectionProperty $property): void
    {
        if ($property->isInitialized($test)) {
            return;
        }

        $attr = AttributeHelper::getAttributeInstance($property, Mock::class);
        if (!$attr) {
            return;
        }

        $type = $property->getType();
        if (!$type) {
            return;
        }

        $mockType = $this->resolveMockType($type);
        if (!$mockType) {
            return;
        }

        $mock = MockFactory::createMock($test, $mockType, $attr->lenient);

        $property->setValue($test, $mock);
    }

    /**
     * Resolves the *real* class/interface to mock from intersection/union types.
     */
    private function resolveMockType(\ReflectionType $type): ?string
    {
        return match (true) {
            $type instanceof ReflectionNamedType => $this->resolveNamedType($type),
            $type instanceof ReflectionIntersectionType => $this->resolveIntersectionType($type),
            $type instanceof ReflectionUnionType => $this->resolveUnionType($type),
            default => null,
        };
    }

    private function resolveNamedType(ReflectionNamedType $type): ?string
    {
        $name = $type->getName();
        return $this->isMockable($name) ? $name : null;
    }

    private function resolveIntersectionType(ReflectionIntersectionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType) {
                $name = $t->getName();
                if ($this->isMockable($name) && $name !== MockObject::class) {
                    return $name;
                }
            }
        }
        return null;
    }

    private function resolveUnionType(ReflectionUnionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType) {
                $name = $t->getName();
                if ($name === 'null') {
                    continue;
                }
                if ($this->isMockable($name)) {
                    return $name;
                }
            }
        }
        return null;
    }

    private function isMockable(string $type): bool
    {
        return (interface_exists($type) || class_exists($type)) && !is_a($type, MockObject::class, true);
    }
}
