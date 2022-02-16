<?php

declare(strict_types=1);

namespace RayTracer;

use Raytracer\Exception\WorldHasNoLightException;
use RayTracer\Shape\ShapeCollection;

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
}
