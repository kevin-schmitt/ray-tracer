<?php

declare(strict_types=1);

namespace RayTracer\Canvas;

use function file_put_contents;
use const PHP_EOL;
use function sprintf;

final class PortablePixmapMapper
{
    private int $maxLength = 70;

    public function map(Canvas $canvas): string
    {
        $buffer = sprintf(
            "P3\n%d %d\n255\n",
            $canvas->getWidth(),
            $canvas->getHeight()
        );
        $lineToCheckMaxLength = '';
        foreach ($canvas->getPixels() as $row) {
            foreach ($row as $pixel) {
                $rgbPixel = sprintf(
                    '%d %d %d',
                    $pixel->redAsInt(),
                    $pixel->greenAsInt(),
                    $pixel->blueAsInt()
                );
                $lineToCheckMaxLength .= $rgbPixel;

                if (strlen($lineToCheckMaxLength) >= $this->maxLength) {
                    $buffer .= PHP_EOL;
                    $lineToCheckMaxLength = '';
                }

                $buffer .= $rgbPixel;
                $buffer .= ' ';
                $lineToCheckMaxLength .= ' ';
            }
        }

        return $buffer.PHP_EOL;
    }

    public function mapToFile(Canvas $canvas, string $target): void
    {
        file_put_contents($target, $this->map($canvas));
    }
}
