<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use RayTracer\Color\Color;
use Raytracer\Exception\WorldHasNoLightException;
use RayTracer\Intersection\IntersectionCollection;
use RayTracer\Material\Material;
use RayTracer\Math\Ray;
use RayTracer\Math\Transformation;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;
use RayTracer\Shape\ShapeCollection;
use RayTracer\Shape\Sphere;
use RayTracer\World;
use Throwable;

class WorldContext implements Context
{
    use ArrayHelperTrait;

    private World $world;
    private PointLight $light;
    private ShapeCollection $shapeCollection;
    private Ray $ray;
    private IntersectionCollection $intersectionCollection;

    /** @BeforeScenario */
    public function before(): void
    {
        $this->shapeCollection = new ShapeCollection();
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
    public function worldCreation(): void
    {
        $this->world = new World();
    }

    /**
     * @Then w contains no objects
     */
    public function worldHasNoObjects(): void
    {
        Assertion::true($this->world->shapes()->isEmpty());
    }

    /**
     * @Then w has no light source
     */
    public function worldHasNoLightSource(): void
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
    public function sphereCreationWithTable(TableNode $table): void
    {
        foreach ($table->getIterator() as $row) {
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
    public function sphereCreationWithTransformation(TableNode $table): void
    {
        foreach ($table as $row) {
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
    public function defaultWorldCreation(): void
    {
        $this->world = World::default();
    }

    /**
     * @Then w.light = light
     */
    public function lightEqualTo(): void
    {
        Assertion::true($this->world->light()->equalTo($this->light));
    }

    /**
     * @Then w contains s1
     */
    public function worldContainsS1(): void
    {
        Assertion::true($this->world->shapes()->at(0)->equalTo($this->shapeCollection->at(0)));
    }

    /**
     * @Then w contains s2
     */
    public function worldContainsS2(): void
    {
        Assertion::true($this->world->shapes()->at(1)->equalTo($this->shapeCollection->at(1)));
    }

    /**
     * @Given r <- point(:pointX, :pointY, :pointZ) vector(:vectorX, :vectorY, :vectorZ)
     */
    public function rayCreation(
        float $pointX, float $pointY, float $pointZ, float $vectorX, float $vectorY, float $vectorZ
    ): void {
        $this->ray = Ray::from(
            Tuple::point($pointX, $pointY, $pointZ),
            Tuple::vector($vectorX, $vectorY, $vectorZ)
        );
    }

    /**
     * @When xs <- intersect_world(:w, :r)
     */
    public function intersectionWorldAndRay(): void
    {
        $this->intersectionCollection = $this->world->intersect($this->ray);
    }

    /**
     * @Then xs.count = :count
     */
    public function intersectionCount(int $count): void
    {
        Assertion::eq($count, $this->intersectionCollection->count());
    }

    /**
     * @Then xs[:arg1].t = :arg2
     */
    public function xsT($arg1, $arg2)
    {
        throw new PendingException();
    }
}
