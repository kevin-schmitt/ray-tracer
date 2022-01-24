<?php

namespace RayTracer\Tests\Context;

use RayTracer\Enum\TypeTuple;
use RayTracer\Model\Tuple;

trait VectorHelperTrait
{
    /**
     * @Given v <- vector(:x, :y, :z)
     */
    public function vector(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
    }
}
