<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use ReflectionClass;

/**
 * @internal
 */
final class ReflectionHelper
{
    public static function callProtectedMethod(string|object $class, string $method, mixed ...$args): mixed
    {
        return (new ReflectionClass($class))
            ->getMethod($method)
            ->invoke(is_string($class) ? null : $class, ...$args);
    }
}
