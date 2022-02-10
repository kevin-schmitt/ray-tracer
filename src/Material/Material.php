<?php

declare(strict_types=1);

namespace RayTracer\Material;

use RayTracer\Color\Color;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;
use RayTracer\Shape\Shape;
use RayTracer\Utils\Comparator;

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

    public function equalTo(self $that) : bool
    {
        if(false === $this->color->equalTo($that->color())) {
            return false;
        }

        if(false === Comparator::float($this->ambient, $that->ambient())) {
            return false;
        }

        if(false === Comparator::float($this->diffuse, $that->diffuse())) {
            return false;
        }

        if(false === Comparator::float($this->specular, $that->specular())) {
            return false;
        }

        if(false === Comparator::float($this->shininess, $that->shininess())) {
            return false;
        }

        return true;
    }

    
    public function lighting(Shape $object, PointLight $light, Tuple $point, Tuple $eye, Tuple $normal, bool $inShadow): Color
    {
        $color = $this->color;

        $effectiveColor = $color->product($light->intensity());
        $ambient        = $effectiveColor->multiplyBy($this->ambient);

        if ($inShadow) {
            return $ambient;
        }

        $lightv           = $light->position()->minus($point)->normalize();
        $light_dot_normal = $lightv->dot($normal);

        if ($light_dot_normal < 0) {
            $diffuse  = Color::from(0, 0, 0);
            $specular = Color::from(0, 0, 0);
        } else {
            $diffuse         = $effectiveColor->multiplyBy($this->diffuse)->multiplyBy($light_dot_normal);
            $reflect_dot_eye = $lightv->negate()->reflect($normal)->dot($eye);

            if ($reflect_dot_eye <= 0) {
                $specular = Color::from(0, 0, 0);
            } else {
                $factor   = $reflect_dot_eye ** $this->shininess;
                $specular = $light->intensity()->multiplyBy($this->specular * $factor);
            }
        }

        return $ambient->plus($diffuse)->plus($specular);
    }
}
