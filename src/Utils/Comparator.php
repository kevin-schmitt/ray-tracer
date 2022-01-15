<?php

declare(strict_types=1);

namespace RayTracer\Utils;

class Comparator
{
    public static function float(float $value1, float $value2): bool
    {
        $epsilon = 0.00001;

        return abs($value1 - $value2) < $epsilon;
    }
}
