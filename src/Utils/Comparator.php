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

    public static function string(string $str1, string $str2): bool
    {
        return trim(preg_replace('/\s+/', '', $str1) ?? '') === trim(preg_replace('/\s+/', '', $str2) ?? '');
    }
}
