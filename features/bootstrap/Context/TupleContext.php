<?php

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use RayTracer\Model\Tuple;
use RayTracer\Model\TupleFactory;
use RayTracer\Model\TupleInterface;
use RayTracer\Utils\Comparator;

/**
 * Defines application features from the specific context.
 */
class TupleContext implements Context
{
    use ArrayHelperTrait;
    private TupleInterface $tuple;
    private TupleInterface $tuple2;

    /**
     * @Given a <- Tuples(:tuples)
     * @Given a <- tuple(:tuples)
     */
    public function aAffectationWithTuples(string $tuples)
    {
        $tupleArray = $this->stringToArrayFloat($tuples);
        $this->tuple = new Tuple(...$tupleArray);
    }

    /**
     * @Given p <- point(:tuple)
     * @Given p1 <- point(:tuple)
     */
    public function pPoint($tuple)
    {
        $tuple = sprintf('%s, %s', $tuple, '1');
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple = TupleFactory::create(...$tupleArray);
    }

    /**
     * @Given p2 <- point(:tuple)
     */
    public function p2Point($tuple)
    {
        $tuple = sprintf('%s, %s', $tuple, '1');
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple2 = TupleFactory::create(...$tupleArray);
    }

    /**
     * @Given p <- vector(:tuple)
     * @Given v1 <- vector(:tuple)
     * @Given zero <- vector(:tuple)
     * @Given v <- vector(:tuple)
     */
    public function givenVector($tuple)
    {
        $tuple = sprintf('%s, %s', $tuple, '0');
        $this->tuple = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Given a <- vector(:tuple)
     */
    public function givenVectorWithW(string $tuple)
    {
        if (count(explode(',', $tuple)) < 4) {
            $tuple = sprintf('%s, %s', $tuple, '0');
        }
        $this->tuple = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Given a1 <- tuple(:tuple)
     */
    public function aTuple(string $tuple)
    {
        $this->tuple = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Given v2 <- vector(:tuple)
     * @Given b <- vector(:tuple)
     */
    public function vectorTupleV2(string $tuple)
    {
        $tuple = sprintf('%s, %s', $tuple, '0');
        $this->tuple2 = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Given a2 <- tuple(:tuple)
     */
    public function aTuple2($tuple)
    {
        $this->tuple2 = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Then a1 + a2  = tuple(:tuple)
     */
    public function additionTuple(string $tuple)
    {
        $this->tuple->add($this->tuple2);
        $this->tupleEqualsArrayValues($tuple);
    }

    /**
     * @Then p1 - p2 = vector(:vector)
     * @Then zero - v2 = vector(:vector)
     */
    public function substrEqualTo($vector)
    {
        $this->tuple->substr($this->tuple2);
        $vector = sprintf('%s, %s', $vector, 0);
        $this->tupleEqualsArrayValues($vector);
    }

    /**
     * @Then v1 - v2 = point(:point)
     */
    public function substrPoinrEqualTo($point)
    {
        $this->tuple->substr($this->tuple2);
        $point = sprintf('%s, %s', $point, 0);
        $this->tupleEqualsArrayValues($point);
    }

    /**
     * @Then v1 - p2 = point(:point)
     */
    public function p1SubstrP2EqualToPoint(string $point)
    {
        $this->tuple->substr($this->tuple2);
        $point = sprintf('%s, %s', $point, 1);
        $this->tupleEqualsArrayValues($point);
    }

    /**
     * @Then p = tuple(:tuple)
     */
    public function tupleEqualsArrayValues(string $tuple)
    {
        $tupleArray = $this->stringToArrayFloat($tuple);
        Assertion::same(true, Comparator::float($this->tuple->getX(), $tupleArray[0]));
        Assertion::same(true, Comparator::float($this->tuple->getY(), $tupleArray[1]));
        Assertion::same(true, Comparator::float($this->tuple->getZ(), $tupleArray[2]));

        if (isset($tupleArray[3])) {
            Assertion::eq($this->tuple->getW(), $tupleArray[3]);
        }
    }

    /**
     * @Then a.x=:x
     */
    public function aEqualToX(float $x)
    {
        Assertion::eq($x, $this->tuple->getX());
    }

    /**
     * @Then a.y=:y
     */
    public function aEqualToY(float $y)
    {
        Assertion::eq($y, $this->tuple->getY());
    }

    /**
     * @Then a.z=:z
     */
    public function aEqualToZ(float $z)
    {
        Assertion::eq($z, $this->tuple->getZ());
    }

    /**
     * @Then a.w=:w
     */
    public function aIsEqualToW(float $w)
    {
        Assertion::eq($w, $this->tuple->getW());
    }

    /**
     * @Then a is a point
     */
    public function aIsAPoint()
    {
        Assertion::eq($this->tuple->getType(), 'point');
    }

    /**
     * @Then a is not a vector
     */
    public function aIsNotAVector()
    {
        Assertion::notEq($this->tuple->getType(), 'vector');
    }

    /**
     * @Then a is a vector
     */
    public function aIsAVector()
    {
        Assertion::eq($this->tuple->getType(), 'vector');
    }

    /**
     * @Then a is not a point
     */
    public function aIsNotAPoint()
    {
        Assertion::notEq($this->tuple->getType(), 'point');
    }

    /**
     * @Then -a = vector(:vector)
     */
    public function aVector($vector)
    {
        $this->tuple->negate();
        $this->tupleEqualsArrayValues($vector);
    }

    /**
     * @Then magnitude = :arg1
     */
    public function magnitudeV($arg1)
    {
        $arg1 = floatval($arg1);
        $magnitude = $this->tuple->getMagnitude();
        Assertion::same(true, Comparator::float($arg1, $magnitude));
    }

    /**
     * @Then a * :coef = tuple(:tuple)
     */
    public function thenAMultiplyToCoefEqualsTo($coef, $tuple)
    {
        $coef = floatval($coef);

        $this->tuple->multiplyBy($coef);
        $this->tupleEqualsArrayValues($tuple);
    }

    /**
     * @Then a \/ :coef = tuple(:tuple)
     */
    public function aTuple3($coef, $tuple)
    {
        $coef = floatval($coef);

        $this->tuple->dividingBy($coef);
        $this->tupleEqualsArrayValues($tuple);
    }

    /**
     * @Then normalize = vector(:vector)
     * @Then normalize = apprixomately vector(:vector)
     */
    public function normalizeVector(string $vector)
    {
        $this->tuple->normalize();
        $this->tupleEqualsArrayValues($vector);
    }

    /**
     * @When norm <- normalize
     */
    public function normNormalizeV()
    {
        $this->tuple->normalize();
    }

    /**
     * @Then dot = :value
     */
    public function dot($dotExcepted)
    {
        $dot = $this->tuple->dot($this->tuple2);
        Assertion::same(true, Comparator::float(floatval($dotExcepted), $dot));
    }

    /**
     * @Then cross(:arg1) = vector(:arg2)
     */
    public function crossVector($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then cross for a, b = vector(:vector)
     */
    public function crossForABVector($vector)
    {
        $vectorCrossed = $this->tuple->cross($this->tuple2);
        $tupleArray = $this->stringToArrayFloat($vector);
        Assertion::same(true, Comparator::float($tupleArray[0], $vectorCrossed->getX()));
        Assertion::same(true, Comparator::float($tupleArray[1], $vectorCrossed->getY()));
        Assertion::same(true, Comparator::float($tupleArray[2], $vectorCrossed->getZ()));
    }

    /**
     * @Then cross for b, a = vector(:vector)
     */
    public function crossForBAVector($vector)
    {
        $vectorCrossed = $this->tuple2->cross($this->tuple);
        $tupleArray = $this->stringToArrayFloat($vector);
        Assertion::same(true, Comparator::float($tupleArray[0], $vectorCrossed->getX()));
        Assertion::same(true, Comparator::float($tupleArray[1], $vectorCrossed->getY()));
        Assertion::same(true, Comparator::float($tupleArray[2], $vectorCrossed->getZ()));
    }
}
