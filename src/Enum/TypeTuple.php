<?php

declare(strict_types=1);

namespace RayTracer\Enum;

use InvalidArgumentException;

final class TypeTuple
{
    public const VECTOR = 0.0;
    public const VECTOR_LABEL = 'vector';
    public const POINT = 1.0;
    public const POINT_LABEL = 'point';

    public static function getTypeByValue(float $value): string
    {
        if (self::VECTOR === $value) {
            return self::VECTOR_LABEL;
        }
        if (self::POINT === $value) {
            return self::POINT_LABEL;
        }

        throw new InvalidArgumentException('Invalid type or tuple');
    }
}
