<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context\Shape;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Enum\TypeTuple;
use RayTracer\Intersection\Intersection;
use RayTracer\Intersection\IntersectionCollection;
use RayTracer\Math\Matrix;
use RayTracer\Math\Ray;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;
use RayTracer\Shape\Shape;
use RayTracer\Shape\Sphere;
use RayTracer\Tests\Context\ArrayHelperTrait;
use RayTracer\Tests\Context\BehatTransformTrait;
use RayTracer\Utils\Comparator;

class SphereContext implements Context
{
    use ArrayHelperTrait;
    use BehatTransformTrait;

    private ?IntersectionCollection $intersectionCollection = null;
    private array $intersections;

    /**
     * @var array Ray
     */
    private array $rays;

    private Shape $sphere;

    private array $matrices;

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
        $this->sphere = Sphere::default();
    }

    /**
     * @When xs <- intersect(:s, :r)
     */
    public function xsIntersectSR()
    {
        $this->intersectionCollection = $this->sphere->intersect($this->rays[0]);
    }

    /**
     * @Then xs.count = :count
     */
    public function xsCount(int $count)
    {
        Assertion::eq($count, $this->intersectionCollection->count());
    }

    /**
     * @Then xs[:index] = :value
     */
    public function xs(int $index, float $value)
    {
        Assertion::eq($value, $this->intersectionCollection->at($index)->t());
    }

    /**
     * @When i <- intersect(:t, i)
     */
    public function intersectWithGivenValue(float $t)
    {
        $this->intersectionCollection = $this->sphere->intersectWith($t);
    }

    /**
     * @Then i.t = :t
     */
    public function intersectValueEqualTo(float $t)
    {
        Assertion::true(Comparator::float($this->intersectionCollection->at(0)->t(), $t));
    }

    /**
     * @Then i.object = s
     */
    public function iIsEqualToSphere()
    {
        Assertion::same($this->intersectionCollection->at(0)->shape(), $this->sphere);
    }

    /**
     * @Then xs[:index].object = s
     */
    public function intersectionSphereIsSmz(int $index)
    {
        Assertion::same($this->intersectionCollection->at($index)->shape(), $this->sphere);
    }

    /**
     * @Given i1 <- intersection(:t, :shapeName)
     * @Given i2 <- intersection(:t, :shapeName)
     */
    public function intersectionAffectationWithStaticT(float $t)
    {
        $this->intersections[] = Intersection::from($t, $this->sphere);
    }

    /**
     * @When xs <- intersections(:intersectionOne, :intersectionTwo)
     */
    public function xsIntersectionsII()
    {
        $this->intersectionCollection = IntersectionCollection::from(...$this->intersections);
    }

    /**
     * @Then xs[:intersectionIndex].t = :t
     */
    public function insectionTEqualTo(int $intersectionIndex, float $t)
    {
        Assertion::true(Comparator::float($this->intersectionCollection->at($intersectionIndex)->t(), $t));
    }

    /**
     * @Then s.transform = identify_matrix
     */
    public function sTransformIdentifyMatrix()
    {
        $this->sphere->transform()->equalTo(Matrix::identify(4));
    }

    /**
     * @Given t <- translation(:x, :y, :z)
     */
    public function translationAffectation(float $x, float $y, float $z)
    {
        $this->matrices[] = Transformation::translation($x, $y, $z);
    }

    /**
     * @When set_transform(:s, :t)
     */
    public function setTransform()
    {
        $this->sphere->setTransform($this->matrices[0]);
    }

    /**
     * @Then s.transform = t
     */
    public function sphereTransformEqualToTranslation()
    {
        Assertion::true($this->sphere->transform()->equalTo($this->matrices[0]));
    }

    /**
     * @When set_transform(s, scaling(:x, :y, :z))
     */
    public function setTransformSScaling(float $x, float $y, float $z)
    {
        $this->sphere->setTransform(Transformation::scaling($x, $y, $z));
    }

    /**
     * @When set_transform(s, translation(:x, :y, :z))
     */
    public function setTransformWitTranslation(float $x, float $y, float $z)
    {
        $this->sphere->setTransform(Transformation::translation($x, $y, $z));
    }
}
