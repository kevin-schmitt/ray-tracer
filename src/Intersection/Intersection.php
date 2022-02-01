<?php

declare(strict_types=1);

namespace RayTracer\Intersection;

use RayTracer\Shape\Shape;

final class Intersection
{
    /**
     * @var array<float>
     */
    private array $values;

    public static function from(float $t, Shape $shape): static
    {
        return new static($t, $shape);
    }

    private function __construct(private float $t, private Shape $shape)
    {
    }

    public function t(): float
    {
        return $this->t;
    }

    public function shape(): Shape
    {
        return $this->shape;
    }

    public function at(int $index): ?float
    {
        return $this->values[$index] ?? null;
    }
}
