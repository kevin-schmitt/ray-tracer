<?php

namespace RayTracer\Array;

interface ArrayConcatenationInterface extends ArrayInterface 
{
    public function add(array $array) : void;
    public function concat() : array;
}