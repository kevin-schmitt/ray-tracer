<?php

declare(strict_types=1);

namespace RayTracer\Model;

use RayTracer\Enum\TypeTuple;

class TupleFactory
{
    public static function point(
        float $x,
        float $y,
        float $z,
        float $w
    ): TupleInterface {
        return new Tuple($x, $y, $z, $w);
    }

    public static function vector(
        float $x,
        float $y,
        float $z,
        float $w
    ): TupleInterface {
        return new Tuple($x, $y, $z, $w);
    }

    public static function create(
        float $x,
        float $y,
        float $z,
        float $w
    ): TupleInterface {
        if (TypeTuple::POINT === $w) {
            return self::point(
                $x,
                $y,
                $z,
                $w
            );
        }

        return self::vector(
            $x,
            $y,
            $z,
            $w
        );
    }
}
