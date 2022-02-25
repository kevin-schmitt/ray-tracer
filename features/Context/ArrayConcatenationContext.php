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
    public function arrayCreation(string $arguments): void
    {
        $this->arrayConcatenation->add($this->stringToArray($arguments));
    }

    /**
     * @Given b <- array(:stringArray)
     */
    public function bArray(string $stringArray): void
    {
        $this->arrayConcatenation->add($this->stringToArray($stringArray));
    }

    /**
     * @When c <- a + b
     */
    public function cAB(): void
    {
    }

    /**
     * @Then c = array(:stringArray)
     */
    public function cArray(string $stringArray): void
    {
        $excepted = $this->stringToArray($stringArray);
        Assertion::eq($excepted, $this->arrayConcatenation->concat());
    }
}
