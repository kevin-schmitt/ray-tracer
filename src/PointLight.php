<?php declare(strict_types=1);

namespace RayTracer;

use RayTracer\Color\Color;
use RayTracer\Material\Material;
use RayTracer\Model\Tuple;

final class PointLight
{
    private function __construct(private Tuple $position, private Color $intensity)
    {}

    public static function from(Tuple $position, Color $intensity) : self
    {
        return new self($position, $intensity);
    }

    public function intensity() : Color
    {
        return $this->intensity;
    }

    public function position() : Tuple
    {
        return $this->position;
    }
}