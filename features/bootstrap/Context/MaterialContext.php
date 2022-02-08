<?php declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Material\Material;

final class MaterialContext implements Context
{

    private Material $material;

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
}