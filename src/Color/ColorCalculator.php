<?php

declare(strict_types=1);

namespace RayTracer\Color;

class ColorCalculator
{
    public function hadamardProduct(Color $c1, Color $c2): Color
    {
        return new Color(
            $c1->red * $c2->red,
            $c1->green * $c2->green,
            $c1->blue * $c2->blue,
        );
    }

    public function adding(Color $c1, Color $c2): Color
    {
        return new Color(
            $c1->red + $c2->red,
            $c1->green + $c2->green,
            $c1->blue + $c2->blue,
        );
    }

    public function substrating(Color $c1, Color $c2): Color
    {
        return new Color(
            $c1->red - $c2->red,
            $c1->green - $c2->green,
            $c1->blue - $c2->blue,
        );
    }

    public function multipliyingByCoef(Color $c, float $coef): Color
    {
        return new Color(
            $coef * $c->red,
            $coef * $c->green,
            $coef * $c->blue,
        );
    }

    public function multipliyingByColor(Color $c1, Color $c2): Color
    {
        return new Color(
            $c1->red * $c2->red,
            $c1->green * $c2->green,
            $c1->blue * $c2->blue,
        );
    }
}
