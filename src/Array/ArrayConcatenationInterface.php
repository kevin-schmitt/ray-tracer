<?php

namespace RayTracer\Array;

interface ArrayConcatenationInterface extends ArrayInterface
{
    /**
     * @param array<string|int> $array
     */
    public function add(array $array): void;

    /**
     * @return array<int|string>
     */
    public function concat(): array;
}
