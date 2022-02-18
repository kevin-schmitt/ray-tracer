<?php

declare(strict_types=1);

namespace RayTracer;

use RayTracer\Color\Color;
use RayTracer\Model\Tuple;

final class PointLight
{
    private function __construct(private Tuple $position, private Color $intensity)
    {
    }

    public static function from(Tuple $position, Color $intensity): self
    {
        return new self($position, $intensity);
    }

    public function intensity(): Color
    {
        return $this->intensity;
    }

    public function position(): Tuple
    {
        return $this->position;
    }

    public function equalTo(PointLight $that) : bool
    {
        if(false === $that->intensity()->equalTo($this->intensity())) {
            return false;
        }

        if(false === $that->position()->equalTo($this->position())) {
            return false;
        }

        return true;
    }
}
