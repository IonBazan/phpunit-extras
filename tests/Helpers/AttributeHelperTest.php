<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Tests\Helpers;

use PHPUnit\Framework\TestCase;
use IonBazan\PHPUnitExtras\Attributes\Mock;
use IonBazan\PHPUnitExtras\Helpers\AttributeHelper;
use ReflectionClass;

class AttributeHelperTest extends TestCase
{
    #[Mock]
    private bool $mock;
    private bool $plain;

    public function testFindPropertiesWithAttribute(): void
    {
        $reflection = new ReflectionClass($this);
        $props = AttributeHelper::findPropertiesWithAttribute($reflection, Mock::class);

        $this->assertCount(1, $props);
        $this->assertSame('mock', $props[0]->getName());
    }
}
