<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use ReflectionClass;

final class SubjectFactory
{
    /**
     * Creates an instance of $subjectClass and injects mocks for constructor parameters.
     *
     * @template T of object
     * @param class-string<T> $subjectClass
     * @param array<string, object> $mockMap  type => mock instance
     * @return T
     */
    public static function create(string $subjectClass, array $mockMap): object
    {
        $reflection = new ReflectionClass($subjectClass);
        $constructor = $reflection->getConstructor();

        $args = [];
        if ($constructor) {
            foreach ($constructor->getParameters() as $param) {
                $type = $param->getType()?->getName();
                if ($type && isset($mockMap[$type])) {
                    $args[] = $mockMap[$type];
                } elseif ($param->isDefaultValueAvailable()) {
                    $args[] = $param->getDefaultValue();
                } else {
                    throw new \RuntimeException("Cannot satisfy constructor param {$param->getName()} of $subjectClass");
                }
            }
        }

        return $constructor
            ? $reflection->newInstance(...$args)
            : $reflection->newInstanceWithoutConstructor();
    }
}
