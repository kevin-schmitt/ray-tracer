<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Enum\TypeTuple;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;
use RayTracer\Model\Tuple;

class RayContext implements Context
{
    use ArrayHelperTrait;
    use BehatTransformTrait;

    /**
     * @var array<Matrix>
     */
    private array $matrices;
    /**
     * @var array<Tuple>
     */
    private array $tuples;

    /**
     * @var array Ray
     */
    private array $rays;

    /**
     * @Given origin <- point(:x, :y, :z)
     */
    public function pointCreation(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::POINT);
    }

    /**
     * @Given direction <- vector(:x, :y, :z)
     */
    public function vectorCreation(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
    }

    /**
     * @When r <- ray(:origin, :direction)
     */
    public function rRayOriginDirection()
    {
        $this->rays[] = Ray::from($this->tuples[0], $this->tuples[1]);
    }

    /**
     * @Then r.origin = origin
     */
    public function originEqualToOrigin()
    {
        Assertion::same($this->tuples[0], $this->rays[0]->origin());
    }

    /**
     * @Then r.direction = direction
     */
    public function directionEqualToDirection()
    {
        Assertion::same($this->tuples[1], $this->rays[0]->direction());
    }
}
