<?php

namespace RayTracer\Tests;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Model\TupleInterface;
use RayTracer\Model\Tuple;
use RayTracer\Tests\ArrayHelperTrait;

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
}
