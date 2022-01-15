<?php

namespace RayTracer\Array;

class ArrayConcatenation implements ArrayConcatenationInterface
{
    /**
     * @var array<array<string|int>>
     */
    private array $listArray = [];

    /**
     * @override
     */
    public function add(array $array): void
    {
        $this->listArray[] = $array;
    }

    /**
     * @override
     */
    public function concat(): array
    {
        return array_merge(...$this->listArray);
    }
}
