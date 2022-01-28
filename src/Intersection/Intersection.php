<?php

declare(strict_types=1);

namespace RayTracer\Intersection;

final class Intersection
{
    /**
     * @var array<float>
     */
    private array $values;

    /**
     * @param array<float> $values
     */
    public static function from(array $values): static
    {
        return new static($values);
    }

    /**
     * @param array<float> $values
     */
    private function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return array<float>
     */
    public function values(): array
    {
        return $this->values;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function at(int $index): ?float
    {
        return $this->values[$index] ?? null;
    }
}
