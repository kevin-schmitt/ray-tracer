<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert as PHPUNIT_ASSERT;
use RayTracer\Canvas\AnsiMapper;
use RayTracer\Canvas\Canvas;
use RayTracer\Canvas\PortablePixmapMapper;
use RayTracer\Color\Color;
use RayTracer\Material\Material;
use RayTracer\Math\Ray;
use RayTracer\Model\Tuple;
use RayTracer\PointLight;
use RayTracer\Shape\Sphere;

class PuttingTogetherContext implements Context
{
    /**
     * @When i generate light and shading
     */
    public function iGenerateLightAndShading(): void
    {
    }

    /**
     * @Then i have file with light and shading file generated
     */
    public function fileEqualToCanvas(): void
    {
        $canvasSize = 150;
        $black = Color::from(0.0, 0.0, 0.0);
        $canvas = Canvas::from($canvasSize, $canvasSize, $black);

        $material = Material::default();
        $material->setColor(Color::from(1, 0.2, 1));

        $s = Sphere::default();
        $s->setMaterial($material);

        $light = PointLight::from(
            Tuple::point(-10, 10, -10),
            Color::from(1, 1, 1)
        );

        $rayOrigin = Tuple::point(0, 0, -5);

        $wallZ = 10;
        $wallSize = 7.0;
        $pixelSize = $wallSize / $canvasSize;
        $halfSize = $wallSize / 2;

        foreach (range(1, $canvasSize) as $x) {
            foreach (range(1, $canvasSize) as $y) {
                $worldX = -$halfSize + $pixelSize * $x;
                $worldY = $halfSize - $pixelSize * $y;
                $position = Tuple::point($worldX, $worldY, $wallZ);
                $ray = Ray::from($rayOrigin, $position->minus($rayOrigin)->normalize());

                if ($s->intersect($ray)->hasHit()) {
                    $hit = $s->intersect($ray)->hit();
                    $point = $ray->position($hit->t());
                    $normal = $hit->shape()->normalAt($point);
                    $eye = $ray->direction()->negate();
                    $color = $hit->shape()->material()->lighting($hit->shape(), $light, $point, $eye, $normal, false);

                    $canvas->writePixel($x, $y, $color);
                }
            }
        }

        PHPUNIT_ASSERT::assertStringEqualsFile(
            __DIR__.'/../fixture/light_and_shading.ansi',
            (new AnsiMapper())->map($canvas)
        );

        PHPUNIT_ASSERT::assertStringEqualsFile(
            __DIR__.'/../fixture/light_and_shading.ppm',
            (new PortablePixmapMapper())->map($canvas)
        );
    }
}
