<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

class Comparator
{
    public const EPSILON = 0.00001;

    public static function equal($a, $b): bool
    {
        if ((abs($a) - abs($b)) < self::EPSILON) {
            return true;
        }

        return false;
    }
}
