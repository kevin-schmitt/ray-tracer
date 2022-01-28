<?php

declare(strict_types=1);

namespace RayTracer\Material;

use RayTracer\Color\Color;

final class Material
{
    private function __construct(
        private Color $color,
        private float $ambient,
        private float $diffuse,
        private float $specular,
        private float $shininess
    ) {
    }

    public static function default(): self
    {
        return self::from(Color::from(1, 1, 1), 0.1, 0.9, 0.9, 200.0);
    }

    public static function from(Color $color, float $ambient, float $diffuse, float $specular, float $shininess): self
    {
        return new self($color, $ambient, $diffuse, $specular, $shininess);
    }

    public function color(): Color
    {
        return $this->color;
    }

    public function setColor(Color $color): void
    {
        $this->color = $color;
    }

    public function ambient(): float
    {
        return $this->ambient;
    }

    public function setAmbient(float $ambient): void
    {
        $this->ambient = $ambient;
    }

    public function diffuse(): float
    {
        return $this->diffuse;
    }

    public function setDiffuse(float $diffuse): void
    {
        $this->diffuse = $diffuse;
    }

    public function specular(): float
    {
        return $this->specular;
    }

    public function setSpecular(float $specular): void
    {
        $this->specular = $specular;
    }

    public function shininess(): float
    {
        return $this->shininess;
    }

    public function setShininess(float $shininess): void
    {
        $this->shininess = $shininess;
    }
}
