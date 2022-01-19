<?php

declare(strict_types=1);

namespace RayTracer\Color;

class Color
{
    public function __construct(
        public float $red,
        public float $green,
        public float $blue
    ) {
    }

    public function getRed(): float
    {
        return $this->red;
    }

    public function redAsInt(): int
    {
        return $this->floatToInt($this->red);
    }

    public function getGreen(): float
    {
        return $this->green;
    }

    public function greenAsInt(): int
    {
        return $this->floatToInt($this->green);
    }

    public function getBlue(): float
    {
        return $this->blue;
    }

    public function blueAsInt(): int
    {
        return $this->floatToInt($this->blue);
    }

    private function floatToInt(float $float): int
    {
        $int = (int) floor($float * 255);

        if ($int < 0) {
            return 0;
        }

        if ($int > 255) {
            return 255;
        }

        return $int;
    }

    public function __toString(): string
    {
        return sprintf('%s%s%s', $this->getRed(), $this->getGreen(), $this->getBlue());
    }
}
