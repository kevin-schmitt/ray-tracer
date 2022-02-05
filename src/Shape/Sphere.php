<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use InvalidArgumentException;
use RayTracer\Enum\TypeTuple;
use RayTracer\Intersection\Intersection;
use RayTracer\Intersection\IntersectionCollection;
use RayTracer\Material\Material;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;

final class Sphere extends Shape
{
    private Tuple $origin;

    private float $radius = 1.0;

    protected function __construct(Matrix $transform, Material $material)
    {
        $this->origin = Tuple::from(0, 0, 0, TypeTuple::POINT);
        parent::__construct($transform, $material);
    }

    public function origin(): Tuple
    {
        return $this->origin;
    }

    public function radius(): float
    {
        return $this->radius;
    }

    public static function default(): static
    {
        return self::from(
            Matrix::identify(4),
            Material::default()
        );
    }

    public static function from(Matrix $transform, Material $material): static
    {
        return new static($transform, $material);
    }

    public function localIntersect(Ray $ray): IntersectionCollection
    {
        $sphereToRay = $ray->origin()->minus($this->origin);

        $a = $ray->direction()->dot($ray->direction());
        $b = 2 * $ray->direction()->dot($sphereToRay);
        $c = $sphereToRay->dot($sphereToRay) - 1;

        $discriminant = $b ** 2 - 4 * $a * $c;

        if ($discriminant < 0) {
            return IntersectionCollection::from();
        }

        $t1 = (-$b - sqrt($discriminant)) / (2 * $a);
        $t2 = (-$b + sqrt($discriminant)) / (2 * $a);

        return IntersectionCollection::from(
            Intersection::from($t1, $this),
            Intersection::from($t2, $this)
        );
    }

    public function intersectWith(float $t): IntersectionCollection
    {
        return IntersectionCollection::from(
            Intersection::from($t, $this)
        );
    }

    public function localNormalAt(Tuple $point): Tuple
    {
        return Tuple::vector($point->getX(), $point->getY(), $point->getZ());
    }
}
