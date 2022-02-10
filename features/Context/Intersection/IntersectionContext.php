<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context\Intersection;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Intersection\Intersection;
use RayTracer\Intersection\IntersectionCollection;
use RayTracer\Shape\Shape;
use RayTracer\Shape\Sphere;
use RayTracer\Tests\Context\ArrayHelperTrait;
use RayTracer\Tests\Context\BehatTransformTrait;
use Throwable;

class IntersectionContext implements Context
{
    use ArrayHelperTrait;
    use BehatTransformTrait;

    private ?IntersectionCollection $intersectionCollection = null;
    private Shape $sphere;
    private array $intersections;

    /**
     * @Given s <- sphere intersections.feature
     */
    public function createDefaultSphere()
    {
        $this->sphere = Sphere::default();
    }

    /**
     * @Given :intersectionNumber <- intersection(:t, :shapeName) intersections.feature
     */
    public function intersectionAffectationWithStaticT(float $t)
    {
        $this->intersections[] = Intersection::from($t, $this->sphere);
    }

    /**
     * @Given xs <- intersections(:a, :b) intersections.feature
     * @Given xs <- intersections(:a, :b, :c, :d) intersections.feature
     */
    public function xsAffectationWithTwoIntersections()
    {
        $this->intersectionCollection = IntersectionCollection::from(...$this->intersections);
    }

    /**
     * @When i <- hit(:xs)
     */
    public function affectHist()
    {
    }

    /**
     * @Then i = :intersectionNumber
     */
    public function iEqualToI1(string $intersectionNumber)
    {
        // i2 -> 1 array begin to 0 and instance gerkin begin to one
        $index = ((int) str_replace('i', '', $intersectionNumber)) - 1;

        Assertion::same($this->intersectionCollection->at($index), $this->intersectionCollection->hit());
    }

    /**
     * @Then i is nothing
     */
    public function iIsNothing()
    {
        try {
            $this->intersectionCollection->hit();
            Assertion::true(false);
        } catch (Throwable $e) {
            Assertion::true(true);
        }
    }
}
