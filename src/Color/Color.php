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

    public static function from(float $red, float $green, float $blue): self
    {
        return new self($red, $green, $blue);
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

    public function equalTo(Color $color, float $delta = 0.00001) : bool
    {
        if (abs($this->red - $color->getRed()) > $delta) {
            return false;
        }

        if (abs($this->green - $color->getGreen()) > $delta) {
            return false;
        }

        if (abs($this->blue - $color->getBlue()) > $delta) {
            return false;
        }

        return true;
    }

    public function product(self $that): self
    {
        return new self(
            $this->red * $that->getRed(),
            $this->green * $that->getGreen(),
            $this->blue * $that->getBlue()
        );
    }

    public function multiplyBy(float $factor): self
    {
        return new self(
            $factor * $this->red,
            $factor * $this->green,
            $factor * $this->blue
        );
    }

    public function plus(self $that): self
    {
        return new self(
            $this->red + $that->getRed(),
            $this->green + $that->getGreen(),
            $this->blue + $that->getBlue()
        );
    }
}
