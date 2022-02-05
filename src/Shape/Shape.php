<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use RayTracer\Intersection\IntersectionCollection;
use RayTracer\Material\Material;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;
use RayTracer\Model\Tuple;

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

    public function intersect(Ray $ray): IntersectionCollection
    {
        $localRay = $ray->transform($this->transform->inverse());

        return $this->localIntersect($localRay);
    }

    abstract public function localIntersect(Ray $ray): IntersectionCollection;

    abstract public function intersectWith(float $t): IntersectionCollection;

    public function transform(): Matrix
    {
        return $this->transform;
    }

    public function setTransform(Matrix $transform): void
    {
        $this->transform = $transform;
    }

    public function normalAt(Tuple $worldPoint): Tuple
    {
        $localPoint = $this->transform->inverse()->multiplyByTuple($worldPoint);
        $localNormal = $this->localNormalAt($localPoint);
        $worldNormal = $this->transform->inverse()->transpose()->multiplyByTuple($localNormal);

        return Tuple::vector($worldNormal->getX(), $worldNormal->getY(), $worldNormal->getZ())->normalize();
    }

    abstract public function localNormalAt(Tuple $point): Tuple;
}
