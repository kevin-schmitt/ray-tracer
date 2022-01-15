<?php

declare(strict_types=1);

namespace RayTracer\Model;

class Projectile
{
    public function __construct(
        private TupleInterface $point,
        private TupleInterface $vector,
    ) {
    }

    public function getPoint(): TupleInterface
    {
        return $this->point;
    }

    public function getVector(): TupleInterface
    {
        return $this->vector;
    }
}
