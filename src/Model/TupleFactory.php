<?php declare(strict_types=1);

namespace RayTracer\Model;

use RayTracer\Enum\TypeTuple;

class TupleFactory { 
    public static function point(
        float $x,
        float $y,
        float $z
    ) : TupleInterface {
        return new Tuple($x, $y, $z, TypeTuple::POINT);
    }

    public static function vector(
        float $x,
        float $y,
        float $z
    ) : TupleInterface {
        return new Tuple($x, $y, $z, TypeTuple::VECTOR);
    }
}