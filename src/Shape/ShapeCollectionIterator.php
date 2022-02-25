<?php

declare(strict_types=1);

namespace RayTracer\Shape;

use Iterator;

/**
 * @phpstan-ignore-next-line
 */
final class ShapeCollectionIterator implements Iterator
{
    /**
     * @var list<Shape>
     */
    private array $shapes;

    private int $position = 0;

    public function __construct(ShapeCollection $shapes)
    {
        $this->shapes = $shapes->asArray();
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->position < count($this->shapes);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): Shape
    {
        return $this->shapes[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }
}
