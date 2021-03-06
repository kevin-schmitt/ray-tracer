<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Enum\TypeTuple;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;
use RayTracer\Model\TupleFactory;

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
    public function rayCreation(
        float $pointX, float $pointY, float $pointZ, float $vectorX, float $vectorY, float $vectorZ
    ): void {
        $this->rays[] = Ray::from(
            Tuple::point($pointX, $pointY, $pointZ),
            Tuple::vector($vectorX, $vectorY, $vectorZ)
        );
    }

    /**
     * @Then position(r, :position) = point(:x, :y, :z)
     */
    public function positionOfRayEqualTo(float $position, float $x, float $y, float $z)
    {
        $point = Tuple::from($x, $y, $z, TypeTuple::POINT);
        Assertion::true($this->rays[0]->position($position)->equalTo($point));
    }

    /**
     * @Given m <- translation(:x, :y, :z)
     */
    public function mTranslation(float $x, float $y, float $z)
    {
        $this->matrices[] = Transformation::translation($x, $y, $z);
    }

    /**
     * @When r2 <- transform(:rayName, :translationName)
     */
    public function transformRay()
    {
        $this->rays[] = $this->rays[0]->transform($this->matrices[0]);
    }

    /**
     * @Then r2.origin = point(:x, :y, :z)
     */
    public function rOriginEqualToPoint(float $x, float $y, float $z)
    {
        $pointExcepted = TupleFactory::point($x, $y, $z);
        Assertion::true($this->rays[1]->origin()->equalTo($pointExcepted));
    }

    /**
     * @Then r2.direction = vector(:x, :y, :z)
     */
    public function rDirectionEqualToVector(float $x, float $y, float $z)
    {
        $vectorExcepted = TupleFactory::vector($x, $y, $z);
        Assertion::true($this->rays[1]->direction()->equalTo($vectorExcepted));
    }

    /**
     * @Given m <- scaling(:x, :y, :z)
     */
    public function scaling(float $x, float $y, float $z)
    {
        $this->matrices[] = Transformation::scaling($x, $y, $z);
    }
}
