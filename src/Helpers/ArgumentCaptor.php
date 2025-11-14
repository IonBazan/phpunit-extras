<?php

declare(strict_types=1);

namespace IonBazan\PHPUnitExtras\Helpers;

use PHPUnit\Framework\Constraint\Constraint;

final class ArgumentCaptor extends Constraint
{
    /** @var array<mixed> */
    private array $values = [];

    public function matches($other): bool
    {
        $this->values[] = $other;
        return true; // always matches
    }

    public function toString(): string
    {
        return 'captures any value';
    }

    /** @return array<mixed> */
    public function getAllValues(): array
    {
        return $this->values;
    }

    public function getValue(): mixed
    {
        return $this->values[0] ?? null;
    }

    public function getLastValue(): mixed
    {
        return $this->values[count($this->values) - 1] ?? null;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function reset(): void
    {
        $this->values = [];
    }
}
