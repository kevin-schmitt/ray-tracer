<?php

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Array\ArrayConcatenation;
use RayTracer\Array\ArrayConcatenationInterface;

/**
 * Defines application features from the specific context.
 */
class ArrayConcatenationContext implements Context
{
    use ArrayHelperTrait;

    private ArrayConcatenationInterface $arrayConcatenation;

    public function __construct()
    {
        $this->arrayConcatenation = new ArrayConcatenation();
    }

    /**
     * @Given a <- array(:arguments)
     */
    public function arrayCreation(string $arguments) : void
    {
        $this->arrayConcatenation->add($this->stringToArray($arguments));
    }

    /**
     * @Given b <- array(:arg1)
     */
    public function bArray($arg1)
    {
        $this->arrayConcatenation->add($this->stringToArray($arg1));
    }

    /**
     * @When c <- a + b
     */
    public function cAB()
    {
    }

    /**
     * @Then c = array(:arg1)
     */
    public function cArray($arg1)
    {
        $arg1 = $this->stringToArray($arg1);
        Assertion::eq($arg1, $this->arrayConcatenation->concat());
    }
}
