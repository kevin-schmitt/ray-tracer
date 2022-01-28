<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use RayTracer\Intersection\Intersection;
use RayTracer\Material\Material;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;

abstract class Shape
{
    protected function __construct(protected Matrix $transform, protected Material $material)
    {
    }

    public static function from(Matrix $transform, Material $material): static
    {
        /* @phpstan-ignore-next-line */
        return new static($transform, $material);
    }

    public function intersect(Ray $ray): Intersection
    {
        $localRay = $ray->transform($this->transform->inverse());

        return $this->localIntersect($localRay);
    }

    abstract public function localIntersect(Ray $ray): Intersection;
}
