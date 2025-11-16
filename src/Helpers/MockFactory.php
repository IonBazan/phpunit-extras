<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class MockFactory
{
    /**
     * @template T of object
     *
     * @param TestCase $test
     * @param class-string<T> $type
     *
     * @return T&MockObject
     */
    public static function createMock(TestCase $test, string $type): object
    {
        return ReflectionHelper::callProtectedMethod($test, 'createMock', $type);
    }

    /**
     * @template T of object
     *
     * @param TestCase $test
     * @param class-string<T> $type
     *
     * @return T&Stub
     */
    public static function createStub(TestCase $test, string $type): object
    {
        return ReflectionHelper::callProtectedMethod($test, 'createStub', $type);
    }
}
