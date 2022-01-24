<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use const M_PI_2;
use const M_PI_4;
use RayTracer\Enum\TypeTuple;
use RayTracer\Math\Matrix;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;

class TransformationContext implements Context
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
     * @Given transform <- translation(:x, :y, :z)
     * @Given C <- translation(:x, :y, :z)
     */
    public function transform(float $x, float $y, float $z)
    {
        $this->matrices[] = Transformation::translation($x, $y, $z);
    }

    /**
     * @Given p <- point(:x, :y, :z)
     */
    public function pointAffectation(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::POINT);
    }

    /**
     * @Then transform * p = point(:x, :y, :z)
     *      * @Then transform * p = p
     */
    public function transformPPoint(float $x, float $y, float $z)
    {
        $pointExcepted = Tuple::from($x, $y, $z, TypeTuple::POINT);
        Assertion::true($this->matrices[0]->multiplyByTuple($this->tuples[0])->equalTo($pointExcepted));
    }

    /**
     * @Given inv <- inverse(:matrixName)
     */
    public function invInverseTransform()
    {
        $this->matrices[] = $this->matrices[0]->inverse();
    }

    /**
     * @Then inv * p = point(:x, :y, :z)
     */
    public function invPPoint(float $x, float $y, float $z)
    {
        $pointExcepted = Tuple::from($x, $y, $z, TypeTuple::POINT);
        Assertion::true($this->matrices[1]->multiplyByTuple($this->tuples[0])->equalTo($pointExcepted));
    }

    /**
     * @Given v <- vector(:x, :y, :z) in transform
     * @Given p <- vector(:x, :y, :z) in transform
     */
    public function vector(float $x, float $y, float $z)
    {
        $this->tuples[] = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
    }

    /**
     * @Then transform * v = v
     */
    public function multiplyByVectorEqualTo()
    {
        Assertion::true($this->matrices[1]->multiplyByTuple($this->tuples[0])->equalTo($this->tuples[0]));
    }

    /**
     * @Given transform <- scaling(:x, :y, :z)
     * @Given B <- scaling(:x, :y, :z)
     */
    public function transformScaling(float $x, float $y, float $z)
    {
        $this->matrices[] = Transformation::scaling($x, $y, $z);
    }

    /**
     * @Then transform * p = vector(:x, :y, :z)
     */
    public function transformPVector(float $x, float $y, float $z)
    {
        $vector = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
        Assertion::true($this->matrices[0]->multiplyByTuple($this->tuples[0])->equalTo($vector));
    }

    /**
     * @Then inv * v = vector(:x, :y, :z)
     */
    public function invVVector(float $x, float $y, float $z)
    {
        $vector = Tuple::from($x, $y, $z, TypeTuple::VECTOR);
        Assertion::true($this->matrices[1]->multiplyByTuple($this->tuples[0])->equalTo($vector));
    }

    /**
     * @Given half_quarter <- rotation_x(π \/ :denominator)
     * @Given full_quarter <- rotation_x(π \/ :denominator)
     * @Given A <- rotation_x(π \/ :arg1)
     */
    public function halfQuarterRotationXP(int $denominator)
    {
        $radiant = (2 === $denominator) ? M_PI_2 : M_PI_4;
        $this->matrices[] = Transformation::rotationAroundX($radiant);
    }

    /**
     * @Given half_quarter <- rotation_y(π \/ :denominator)
     * @Given full_quarter <- rotation_y(π \/ :denominator)
     */
    public function affectationRotatingY(int $denominator)
    {
        $radiant = (2 === $denominator) ? M_PI_2 : M_PI_4;
        $this->matrices[] = Transformation::rotationAroundY($radiant);
    }

    /**
     * @Given half_quarter <- rotation_z(π \/ :demnominator)
     * @Given full_quarter <- rotation_z(π \/ :arg1)
     */
    public function affectationRotatingZ(int $denominator)
    {
        $radiant = (2 === $denominator) ? M_PI_2 : M_PI_4;
        $this->matrices[] = Transformation::rotationAroundZ($radiant);
    }

    /**
     * @Then half_quarter * p = point(:x, :y, :z)
     */
    public function halfQuarterPPoint(string $x, string $y, string $z)
    {
        $x = ('√2/2' == $x) ? sqrt(2) / 2 : (('-√2/2' == $x) ? -sqrt(2) / 2 : floatval($x));
        $y = ('√2/2' == $y) ? sqrt(2) / 2 : (('-√2/2' == $y) ? -sqrt(2) / 2 : floatval($y));
        $z = ('√2/2' == $z) ? sqrt(2) / 2 : (('-√2/2' == $z) ? -sqrt(2) / 2 : floatval($z));

        $point = Tuple::from($x, $y, $z, TypeTuple::POINT);

        Assertion::true($this->matrices[0]->multiplyByTuple($this->tuples[0])->equalTo($point));
    }

    /**
     * @Then full_quarter * p = point(:x, :y, :z)
     */
    public function fullQuarterPPoint(float $x, float $y, float $z)
    {
        $point = Tuple::from($x, $y, $z, TypeTuple::POINT);

        Assertion::true($this->matrices[1]->multiplyByTuple($this->tuples[0])->equalTo($point));
    }

    /**
     * @Then inv * p = point(0, √:arg1\/2, -√:arg2\/:arg3)
     */
    public function invMultiplyEqual()
    {
        $point = Tuple::from(0, sqrt(2) / 2, -sqrt(2) / 2, TypeTuple::POINT);
        $inverse = Transformation::rotationAroundX(M_PI_4)->inverse();
        Assertion::true($inverse->multiplyByTuple($this->tuples[0])->equalTo($point));
    }

    /**
     * @Given transform <- shearing(:parameters)
     */
    public function transformShearing(string $parameters)
    {
        $this->matrices[] = Transformation::shearing(...$this->stringToArrayFloat($parameters));
    }

    /**
     * @When p2 <- A * p
     */
    public function tupleMultiplyBy()
    {
        $this->tuples[] = $this->matrices[0]->multiplyByTuple($this->tuples[0]);
    }

    /**
     * @Then p2 = point(:x, :y, :z)
     */
    public function p2EqualToPoint(float $x, float $y, float $z)
    {
        Assertion::true($this->tuples[1]->equalTo(Tuple::from($x, $y, $z, TypeTuple::POINT)));
    }

    /**
     * @When p3 <- B * p2
     */
    public function p3AffectationByMultiplication()
    {
        $this->tuples[] = $this->matrices[1]->multiplyByTuple($this->tuples[1]);
    }

    /**
     * @Then p3 = point(:x, :y, :z)
     */
    public function pPoint2(float $x, float $y, float $z)
    {
        Assertion::true($this->tuples[2]->equalTo(Tuple::from($x, $y, $z, TypeTuple::POINT)));
    }

    /**
     * @When p4 <- C * p3
     */
    public function p4AffectationByMultiplication()
    {
        $this->tuples[] = $this->matrices[2]->multiplyByTuple($this->tuples[2]);
    }

    /**
     * @Then p4 = point(:x, :y, :z)
     */
    public function p4EqualToPoint(float $x, float $y, float $z)
    {
        Assertion::true($this->tuples[3]->equalTo(Tuple::from($x, $y, $z, TypeTuple::POINT)));
    }

    /**
     * @When T <- A * B * C
     */
    public function tMultiplyByABC()
    {
        $this->matrices[] = $this->matrices[2]
            ->multiply($this->matrices[1])
            ->multiply($this->matrices[0]);
    }

    /**
     * @Then T * p = point(:x, :y, :z)
     */
    public function tMultiplyByPEqualToPoint(float $x, float $y, float $z)
    {
        Assertion::true(
            $this->matrices[3]->multiplyByTuple($this->tuples[0])
                ->equalTo(Tuple::from($x, $y, $z, TypeTuple::POINT))
        );
    }
}
