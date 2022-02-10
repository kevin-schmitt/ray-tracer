<?php

namespace RayTracer\Tests\Context;

use RayTracer\Enum\TypeTuple;
use RayTracer\Model\Tuple;

trait VectorHelperTrait
{
    /**
     * @Given p <- vector(:tuple)
     * @Given v1 <- vector(:tuple)
     * @Given zero <- vector(:tuple)
     * @Given v <- vector(:x, :y, :z)
     */
    public function vector(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
    }
}
