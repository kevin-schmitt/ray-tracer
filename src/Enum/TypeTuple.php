<?php declare(strict_types=1);

namespace RayTracer\Enum;
 
final class TypeTuple {
    const VECTOR = 0.0;
    const VECTOR_LABEL = 'vector';
    const POINT = 1.0;
    const POINT_LABEL = 'point';

    public static function getTypeByValue(float $value) : string
    {
        if($value === self::VECTOR) {
            return self::VECTOR_LABEL;
        }
        if($value === self::POINT) {
            return self::POINT_LABEL;
        }
    }
}