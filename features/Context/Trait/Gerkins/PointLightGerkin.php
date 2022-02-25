<?php

namespace RayTracer\Tests\Context\Trait\Gerkins;

use RayTracer\Color\Color;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;

/**
 *  @require pointLight property
 */
trait PointLightGerkin
{
    /**
     * @When light <- point_light(point(:x, :y, :z), color(:red, :green, :blue))
     * @Given light <- point_light(point(:x, :y, :z), color(:red, :green, :blue))
     */
    public function pointLightCreation(float $x, float $y, float $z, float $red, float $green, float $blue): void
    {
        $this->pointLight = PointLight::from(
            Tuple::point($x, $y, $z),
            Color::from($red, $green, $blue)
        );
    }
}
