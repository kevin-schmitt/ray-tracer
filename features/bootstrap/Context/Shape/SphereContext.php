<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context\Shape;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Enum\TypeTuple;
use RayTracer\Math\Ray;
use RayTracer\Model\Tuple;
use RayTracer\Shape\Sphere;
use RayTracer\Tests\Context\ArrayHelperTrait;
use RayTracer\Tests\Context\BehatTransformTrait;

class SphereContext implements Context
{
    use ArrayHelperTrait;
    use BehatTransformTrait;

    /**
     * @var array<Intersection>
     */
    private array $intersections;

    /**
     * @var array Ray
     */
    private array $rays;

    /**
     * @var array Sphere
     */
    private array $spheres;

    /**
     * @Given r <- point(:pointX, :pointY, :pointZ) vector(:vectorX, :vectorY, :vectorZ) spheres.feature
     */
    public function rayInitialisation(
        float $pointX, float $pointY, float $pointZ, float $vectorX, float $vectorY, float $vectorZ
    ) {
        $this->rays[] = Ray::from(
            Tuple::from($pointX, $pointY, $pointZ, TypeTuple::POINT),
            Tuple::from($vectorX, $vectorY, $vectorZ, TypeTuple::VECTOR)
        );
    }

    /**
     * @Given s <- sphere
     */
    public function sAffectationSphere()
    {
        $this->spheres[] = Sphere::default();
    }

    /**
     * @When xs <- intersect(:s, :r)
     */
    public function xsIntersectSR()
    {
        $this->intersections[] = $this->spheres[0]->intersect($this->rays[0]);
    }

    /**
     * @Then xs.count = :count
     */
    public function xsCount(int $count)
    {
        Assertion::eq($count, $this->intersections[0]->count());
    }

    /**
     * @Then xs[:index] = :value
     */
    public function xs(int $index, float $value)
    {
        Assertion::eq($value, $this->intersections[0]->at($index));
    }
}
