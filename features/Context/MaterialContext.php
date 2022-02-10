<?php declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Color\Color;
use RayTracer\Material\Material;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;
use RayTracer\Shape\Sphere;

final class MaterialContext implements Context
{

    private Material $material;
    private Tuple $point1;
    private Tuple $vector1;
    private PointLight $pointLight;
    private Tuple $normal;
    private Color $result;

    /**
     * @Given m <- material()
     */
    public function materialCreation()
    {
        $this->material = Material::default();
    }

    /**
     * @Then m.ambient = :ambient
     */
    public function ambientEqualTo(float $ambient)
    {
        Assertion::eq($ambient, $this->material->ambient());
    }

    /**
     * @Then m.diffuse = :diffuse
     */
    public function mDifdiffuseEqualTo(float $diffuse)
    {
        Assertion::eq($diffuse, $this->material->diffuse());
    }

    /**
     * @Then m.spectacular = :spectacular
     */
    public function spectacularEqualTo(float $spectacular)
    {
        Assertion::eq($spectacular, $this->material->specular());
    }

    /**
     * @Then m.shininess = :shininess
     */
    public function shininessEqualTo(float $shiniess)
    {
        Assertion::eq($shiniess, $this->material->shininess());
    }

    /**
     * @Given position <- point(:x, :y, :z)
     */
    public function positionCreation(float $x, float $y, float $z)
    {
        $this->point1 = Tuple::point($x, $y, $z);
    }

    /**
     * @Given eyeV <- vector(:x, :y, :z)
     */
    public function eyevVector(float $x, float $y, float $z) : void
    {
        $this->vector1 = Tuple::vector($x, $y, $z);
    }

    /**
     * @When light <- point_light(point(:x, :y, :z), color(:red, :green, :blue))
     */
    public function pointLightCreation(float $x, float $y, float $z, float $red, float $green, float $blue) : void
    {
        $this->pointLight = PointLight::from(
            Tuple::point($x, $y, $z),
            Color::from($red, $green, $blue)
        );
    }

    /**
     * @Given normalv <- vector(:x, :y, :z)
     */
    public function normalCreation(float $x, float $y, float $z) : void
    {
        $this->normal = Tuple::vector($x, $y, $z);
    }
   
    /**
     * @When result <- lighting(:m, :light, :position, :eyev, :normalv)
     */
    public function resultLightingMLightPositionEyevNormalv()
    {
        $this->result = $this->material->lighting(Sphere::default(), $this->pointLight, $this->point1, $this->vector1, $this->normal, false);
    }

    /**
     * @Then result = color(:red, :green, :blue)
     */
    public function resultEqualToColor(float $red, float $green, float $blue) : void
    {
        Assertion::true($this->result->equalTo(Color::from($red, $green, $blue)));
    }

}