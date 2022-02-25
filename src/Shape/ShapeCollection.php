<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use Countable;
use IteratorAggregate;
use OutOfBoundsException;

/**
 * @phpstan-ignore-next-line
 */
final class ShapeCollection implements Countable, IteratorAggregate
{
    /**
     * @var array<Shape>
     */
    private array $shapes = [];

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function count(): int
    {
        return count($this->shapes);
    }

    public function add(Shape $shape): void
    {
        $this->shapes[] = $shape;
    }

    /**
     * @return list<Shape>
     */
    public function asArray(): array
    {
        return $this->shapes;
    }

    /**
     * @throws OutOfBoundsException
     */
    public function at(int $position): Shape
    {
        if (false === isset($this->shapes[$position])) {
            throw new OutOfBoundsException();
        }

        return $this->shapes[$position];
    }

    public function getIterator(): ShapeCollectionIterator
    {
        return new ShapeCollectionIterator($this);
    }
}
