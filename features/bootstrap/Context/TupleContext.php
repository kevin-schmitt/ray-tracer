<?php

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Model\TupleInterface;
use RayTracer\Model\Tuple;
use RayTracer\Model\TupleFactory;
use RayTracer\Tests\Context\ArrayHelperTrait;

/**
 * Defines application features from the specific context.
 */
class TupleContext implements Context
{
    use ArrayHelperTrait;
    private TupleInterface $tuple;

     /**
     * @Given a <- Tuples(:tuples)
     */
    public function aAffectationWithTuples(string $tuples)
    {
        $tupleArray = $this->stringToArrayFloat($tuples);
        $this->tuple = new Tuple(...$tupleArray);
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
     * @Given p <- point(:tuple)
     */
    public function pPoint($tuple)
    {
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple = TupleFactory::point(...$tupleArray);
    }

    /**
     * @Given p <- vector(:tuple)
     */
    public function pVector($tuple)
    {
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple = TupleFactory::vector(...$tupleArray);
    }

    /**
     * @Then p = tuple(:arg1)
     */
    public function pTuple($tuple)
    {
        $tupleArray = $this->stringToArrayFloat($tuple);
        Assertion::eq($this->tuple->getX(), $tupleArray[0]);
        Assertion::eq($this->tuple->getY(), $tupleArray[1]);
        Assertion::eq($this->tuple->getZ(), $tupleArray[2]);
        Assertion::eq($this->tuple->getW(), $tupleArray[3]);
    }


}
