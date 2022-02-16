<?php

declare(strict_types=1);

namespace RayTracer\Shape;

final class ShapeCollection
{
    /**
     * @param $shapes array<Shape>
     */
    private array $shapes = [];

    public function isEmpty() : bool
    {
        return 0 === $this->count();
    }

    public function count() : int
    {
        return count($this->shapes);
    }
}
