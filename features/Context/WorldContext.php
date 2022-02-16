<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Behat\Behat\Context\Context;
use Assert\Assertion;
use RayTracer\World;
use PHPUnit\Framework\Assert as PHPUNIT_ASSERT;
use Raytracer\Exception\WorldHasNoLightException;
use Throwable;

class WorldContext implements Context
{
    private World $world;

      /**
     * @Given w <- world()
     */
    public function worldCreation() : void
    {
        $this->world = new World;
    }

    /**
     * @Then w contains no objects
     */
    public function worldHasNoObjects() : void
    {
        Assertion::true($this->world->shapes()->isEmpty());
    }

    /**
     * @Then w has no light source
     */
    public function worldHasNoLightSource() : void
    {
        try {
            $this->world->light();
        } catch (Throwable $worldHasNoLightException) {
            //  @todo use WorldHasNoLightException
            Assertion::true(true);
            return;
        }

        Assertion::true(false);
    }
}
