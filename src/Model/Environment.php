<?php

declare(strict_types=1);

namespace RayTracer\Model;

class Environment
{
    public function __construct(
        private TupleInterface $vector1,
        private TupleInterface $vector2,
    ) {
    }

    public function getVector1(): TupleInterface
    {
        return $this->vector1;
    }

    public function getVector2(): TupleInterface
    {
        return $this->vector2;
    }
}
