<?php

namespace RayTracer\Model;

interface TupleInterface
{
    public function getX(): float;

    public function getY(): float;

    public function getZ(): float;

    public function getW(): float;

    public function getType(): string;

    public function add(TupleInterface $tuple): void;

    public function substr(TupleInterface $tuple): Tuple;

    public function negate(): Tuple;

    public function multiplyBy(float $coef): Tuple;

    public function dividingBy(float $coef): void;

    public function getMagnitude(): float;

    public function normalize(): Tuple;

    public function dot(TupleInterface $tuple): float;

    public function cross(TupleInterface $tuple): TupleInterface;

    public function equalTo(self $that): bool;
}
