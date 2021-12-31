<?php declare(strict_types=1);

namespace RayTracer\Enum;
 
final class TypeTuple {
    const VECTOR = 'vector';
    const POINT = 'point';

    const TYPES = [
        0.0 => self::VECTOR,
        1.0 => self::POINT
    ];
}