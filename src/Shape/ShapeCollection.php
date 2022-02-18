<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use OutOfBoundsException;

final class ShapeCollection
{
    /**
     * @var array<Shape>
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

    public function add(Shape $shape) : void
    {
        $this->shapes[] = $shape;
    }

    /**
     * @throws OutOfBoundsException
    */
    public function at(int $position): Shape
    {
        if (false === isset($this->shapes[$position])) {
            throw new OutOfBoundsException;
        }

        return $this->shapes[$position];
    }
}
