<?php

namespace RayTracer\Array;

class ArrayConcatenation implements ArrayConcatenationInterface
{
    private array $listArray = [];

    public function add(array $array) : void 
    {
        $this->listArray[] = $array;
    }

    public function concat() : array
    {
        return array_merge(...$this->listArray);
    }
}