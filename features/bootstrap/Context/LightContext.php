<?php declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Color\Color;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;

final class LightContext implements Context
{
    private Color $color1;
    private Tuple $tuple1;
    private PointLight $pointLight;

    /**
     * @Given intensity <- color(:red, :green, :blue)
     */
    public function intensityColor(float $red, float $green, float $blue)
    {
        $this->color1 = Color::from($red, $green, $blue);
    }

    /**
     * @Given position <- point(:x, :y, :z)
     */
    public function positionPoint(float $x, float $y, float $z)
    {
        $this->tuple1 = tuple::point($x, $y, $z);
    }

    /**
     * @When light <- point_light(:position, :intensity)
     */
    public function pointLightCreation()
    {
        $this->pointLight = PointLight::from($this->tuple1, $this->color1);
    }

    /**
     * @Then light.position = position
     */
    public function lightPositionPosition()
    {
        Assertion::true($this->pointLight->position()->equalTo($this->tuple1));
    }

    /**
     * @Then light.intensity = intensity
     */
    public function lightIntensityIntensity()
    {
        Assertion::true($this->pointLight->intensity()->equalTo($this->color1));
    }
}