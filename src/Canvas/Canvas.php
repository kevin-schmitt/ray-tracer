<?php

declare(strict_types=1);

namespace RayTracer\Canvas;

use RayTracer\Color\Color;

class Canvas
{
    /**
     * @phpstan-ignore-next-line
     */
    private array $pixels;

    public function __construct(
        private int $width,
        private int $height,
        ?Color $background = null
    ) {
        $this->initializePixels($background);
    }

    public static function from(int $width, int $height, Color $background): self
    {
        return new self($width, $height, $background);
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function getPixels(): array
    {
        return $this->pixels;
    }

    public function initializePixels(?Color $background): void
    {
        $this->pixels = [];
        $background = (null === $background) ? new Color(0, 0, 0) : $background;

        foreach (range(1, $this->width) as $x) {
            foreach (range(1, $this->height) as $y) {
                $this->pixels[$x][$y] = $background;
            }
        }
    }

    public function pixelAt(int $x, int $y): ?Color
    {
        return $this->pixels[$x][$y] ?? null;
    }

    public function writePixel(int $x, int $y, Color $color): Color
    {
        return $this->pixels[$x][$y] = $color;
    }
}
