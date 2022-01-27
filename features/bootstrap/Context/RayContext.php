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

    /**
     * @Given r <- point(:pointX, :pointY, :pointZ) vector(:vectorX, :vectorY, :vectorZ)
     */
    public function rayInitialisation(
        float $pointX, float $pointY, float $pointZ, float $vectorX, float $vectorY, float $vectorZ
    )
    {
        $this->rays[] = Ray::from(
            Tuple::from($pointX, $pointY, $pointZ, TypeTuple::POINT),
            Tuple::from($vectorX, $vectorY, $vectorZ, TypeTuple::VECTOR)
        );
    }

    /**
     * @Then position(r, :position) = point(:x, :y, :z)
     */
    public function positionOfRayEqualTo(float $position, float $x, float $y, float $z)
    {
        $point = Tuple::from($x, $y, $z, TypeTuple::POINT);
        if($this->rays[0]->position($position)->equalTo($point) === false) {
            var_dump($this->rays[0]->position($position), $point);
        }
        Assertion::true($this->rays[0]->position($position)->equalTo($point));
    }
}
