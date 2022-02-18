<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Behat\Behat\Context\Context;
use Assert\Assertion;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use RayTracer\World;
use PHPUnit\Framework\Assert as PHPUNIT_ASSERT;
use RayTracer\Color\Color;
use Raytracer\Exception\WorldHasNoLightException;
use RayTracer\Material\Material;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;
use RayTracer\Shape\ShapeCollection;
use RayTracer\Shape\Sphere;
use Throwable;

class WorldContext implements Context
{
    use ArrayHelperTrait;

    private World $world;
    private PointLight $light;
    private ShapeCollection $shapeCollection;

    /** @BeforeScenario */
    public function before() : void
    {
        $this->shapeCollection = new ShapeCollection;
    }

    /**
     * @Given light <- point_light(point(:x, :y, :z), color(:red, :green, :blue))
     */
    public function pointLightCreation(float $x, float $y, float $z, float $red, float $green, float $blue): void
    {
        $this->light = PointLight::from(
            Tuple::point($x, $y, $z),
            Color::from($red, $green, $blue)
        );
    }

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

    /**
     * @Given s1 <- sphere() with:
     * @phpstan-ignore-next-line
     */
    public function sphereCreationWithTable(TableNode $table) : void
    {
        foreach($table->getIterator() as $row) {
            $sphere = Sphere::default();
            $material = Material::default();
            $sphere->setMaterial(
                Material::from(
                    Color::from(...$this->stringToArrayFloat($row['material.color'])),
                    $material->ambient(),
                    floatval($row['material.diffuse']),
                    floatval($row['material.specular']),
                    $material->shininess()
                )
            );
            $this->shapeCollection->add($sphere);
        }
    }

    /**
     * @Given s2 <- sphere with:
     * @phpstan-ignore-next-line
     */
    public function sphereCreationWithTransformation(TableNode $table) : void
    {
        foreach($table as $row) {
            $sphere = Sphere::default();
            $this->shapeCollection->add(
                $sphere->setTransform(
                    Transformation::scaling(...$this->stringToArrayFloat($row['transform']))
                )
            );
        }
    }

    /**
     * @When w <- default_world()
     */
    public function defaultWorldCreation() : void
    {
        $this->world = World::default();
    }

    /**
     * @Then w.light = light
     */
    public function lightEqualTo() : void
    {
        Assertion::true($this->world->light()->equalTo($this->light));
    }

    /**
     * @Then w contains s1
     */
    public function worldContainsS1() : void
    {
        Assertion::true($this->world->shapes()->at(0)->equalTo($this->shapeCollection->at(0)));
    }

    /**
     * @Then w contains s2
     */
    public function worldContainsS2() : void
    {
        Assertion::true($this->world->shapes()->at(1)->equalTo($this->shapeCollection->at(1)));
    }
}
