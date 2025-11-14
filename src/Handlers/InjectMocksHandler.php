<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Handlers;

use IonBazan\PHPUnitExtras\Attributes\InjectMocks;
use IonBazan\PHPUnitExtras\Helpers\AttributeHelper;
use IonBazan\PHPUnitExtras\Helpers\SubjectFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

final class InjectMocksHandler implements Handler
{
    public function handle(TestCase $test, ReflectionClass $reflection): void
    {
        $injectProps = AttributeHelper::findPropertiesWithAttribute($reflection, InjectMocks::class);
        foreach ($injectProps as $property) {
            $this->injectIntoProperty($test, $property, $reflection);
        }
    }

    private function injectIntoProperty(TestCase $test, ReflectionProperty $property, ReflectionClass $testReflection): void
    {
        $type = $property->getType();
        if (!$type || $property->isInitialized($test)) {
            return;
        }

        $subjectType = $this->resolveSubjectType($type);
        if (!$subjectType || !class_exists($subjectType)) {
            return;
        }

        $mockMap = $this->buildMockMap($test, $testReflection);
        $subject = SubjectFactory::create($subjectType, $mockMap);

        $subjectReflection = new ReflectionClass($subject);
        foreach ($subjectReflection->getProperties() as $p) {
            if ($p->isStatic() || $p->isReadOnly() || $p->isInitialized($subject)) {
                continue;
            }
            $pType = $p->getType()?->getName();
            if ($pType && isset($mockMap[$pType]) && $p->isPublic()) {
                $p->setValue($subject, $mockMap[$pType]);
            }
        }

        $property->setValue($test, $subject);
    }

    private function resolveSubjectType(\ReflectionType $type): ?string
    {
        return match (true) {
            $type instanceof ReflectionNamedType => $type->getName(),
            $type instanceof ReflectionIntersectionType => $this->resolveIntersectionSubject($type),
            $type instanceof ReflectionUnionType => $this->resolveUnionSubject($type),
            default => null,
        };
    }

    private function resolveIntersectionSubject(ReflectionIntersectionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType && class_exists($t->getName())) {
                return $t->getName();
            }
        }
        return null;
    }

    private function resolveUnionSubject(ReflectionUnionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType && $t->getName() !== 'null' && class_exists($t->getName())) {
                return $t->getName();
            }
        }
        return null;
    }

    /** @return array<string, object> */
    private function buildMockMap(TestCase $test, ReflectionClass $testReflection): array
    {
        $map = [];
        foreach ($testReflection->getProperties() as $prop) {
            $type = $prop->getType();
            if (!$type || !$prop->isInitialized($test)) {
                continue;
            }

            $mockType = $this->resolveMockTypeFromProperty($type);
            if (!$mockType) {
                continue;
            }

            $value = $prop->getValue($test);
            if ($value instanceof MockObject || ($value instanceof $mockType)) {
                $map[$mockType] = $value;
            }
        }
        return $map;
    }

    private function resolveMockTypeFromProperty(\ReflectionType $type): ?string
    {
        return match (true) {
            $type instanceof ReflectionNamedType => $this->isMockable($type->getName()) ? $type->getName() : null,
            $type instanceof ReflectionIntersectionType => $this->resolveIntersectionMock($type),
            $type instanceof ReflectionUnionType => $this->resolveUnionMock($type),
            default => null,
        };
    }

    private function resolveIntersectionMock(ReflectionIntersectionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType) {
                $name = $t->getName();
                if ($name !== \PHPUnit\Framework\MockObject\MockObject::class && $this->isMockable($name)) {
                    return $name;
                }
            }
        }
        return null;
    }

    private function resolveUnionMock(ReflectionUnionType $type): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($t instanceof ReflectionNamedType && $t->getName() !== 'null' && $this->isMockable($t->getName())) {
                return $t->getName();
            }
        }
        return null;
    }

    private function isMockable(string $type): bool
    {
        return interface_exists($type) || class_exists($type);
    }
}
