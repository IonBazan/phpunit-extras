<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MockFactory
{
    /**
     * @template T of object
     *
     * @param TestCase $test
     * @param class-string<T> $type
     * @param bool $lenient
     *
     * @return T&MockObject
     */
    public static function createMock(TestCase $test, string $type, bool $lenient): object
    {
        $builder = new MockBuilder($test, $type);
        if ($lenient) {
            $builder = $builder->disableOriginalConstructor();
        }
        return $builder->getMock();
    }

}
