<?php

namespace RayTracer\Tests;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use RayTracer\Array\ArrayOperation;
use RayTracer\Array\ArrayOperationInterface;
use RayTracer\Tests\ArrayHelperTrait;

/**
 * Defines application features from the specific context.
 */
class ArrayContext implements Context
{
    use ArrayHelperTrait;

    private ArrayOperationInterface $arrayOperation;
    private array $arg1;
    private array $arg2;
    private array $result;

    public function __construct() {
        $this->arrayOperation = new ArrayOperation();
    }

     /**
     * @Given a <- array(:arg1)
     */
    public function aArray($arg1)
    {
        $this->arg1 = $this->stringToArray($arg1);
    }

    /**
     * @Given b <- array(:arg1)
     */
    public function bArray($arg1)
    {
        $this->arg2 = $this->stringToArray($arg1);
    }

    /**
     * @When c <- a + b
     */
    public function cAB()
    {
       $this->result = array_merge($this->arg1, $this->arg2);

    }

    /**
     * @Then c = array(:arg1)
     */
    public function cArray($arg1)
    {
        $arg1 = $this->stringToArray($arg1);
        if($arg1 !== $this->result) {
            throw new \Exception('Not equals');
        }
    }

 
}
