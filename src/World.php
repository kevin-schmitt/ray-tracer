<?php

declare(strict_types=1);

namespace RayTracer;

use RayTracer\Color\Color;
use Raytracer\Exception\WorldHasNoLightException;
use RayTracer\Material\Material;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;
use RayTracer\Shape\Shape;
use RayTracer\Shape\ShapeCollection;
use RayTracer\Shape\Sphere;

final class World
{
    private ShapeCollection $shapes;
    private ?PointLight $light = null;

    public function __construct()
    {
        $this->shapes = new ShapeCollection();
    }

    public function shapes() : ShapeCollection
    {
        return $this->shapes;
    }

    public function light() : PointLight
    {
        if(null === $this->light) {
            // @todo to fix not found
            throw new WorldHasNoLightException;
        }

        return $this->light;
    }

    public static function default(): self
    {
        $light = PointLight::from(
            Tuple::point(-10, 10, -10),
            Color::from(1, 1, 1)
        );

        $s1 = Sphere::default();
        $s1->setMaterial(Material::from(Color::from(0.8, 1.0, 0.6), 0.1, 0.7, 0.2, 200.0));

        $s2 = Sphere::default();
        $s2->setTransform(Transformation::scaling(0.5, 0.5, 0.5));

        $w = new self;

        $w->add($s1);
        $w->add($s2);
        $w->setLight($light);

        return $w;
    }

    public function add(Shape $shape): void
    {
        $this->shapes->add($shape);
    }

    public function setLight(PointLight $light): void
    {
        $this->light = $light;
    }
}
