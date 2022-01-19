<?php

declare(strict_types=1);

namespace RayTracer;

use Exception;
use RayTracer\Canvas\Canvas;

final class WebpMapper
{
    public function map(Canvas $canvas, string $target): void
    {
        $colors = [];

        $image = imagecreatetruecolor($canvas->getWidth(), $canvas->getHeight());

        if (false === $image) {
            throw new Exception('Impossible to create image');
        }

        foreach (range(1, $canvas->getWidth()) as $x) {
            foreach (range(1, $canvas->getHeight()) as $y) {
                $color = $canvas->pixelAt($x, $y);

                if (null === $color) {
                    return;
                }

                $key = $color->getRed().$color->getGreen().$color->getBlue();

                if (true === empty($colors[$key])) {
                    $colors[$key] = imagecolorallocate(
                        $image,
                        $color->redAsInt(),
                        $color->greenAsInt(),
                        $color->blueAsInt()
                    );

                    if (false === $colors[$key]) {
                        throw new Exception('Impossible to use imagecolorallocate in '.self::class);
                    }
                }

                imagesetpixel(
                    $image,
                    $x,
                    $y,
                    $colors[$key]
                );
            }
        }

        imagewebp($image, $target, 100);
    }
}
