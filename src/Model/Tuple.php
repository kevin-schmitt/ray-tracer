<?php

declare(strict_types=1);

namespace RayTracer\Model;

use RayTracer\Enum\TypeTuple;
use RayTracer\Utils\Comparator;
use RuntimeException;

class Tuple implements TupleInterface
{
    public function __construct(
        private float $x,
        private float $y,
        private float $z,
        private float $w
    ) {
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function getZ(): float
    {
        return $this->z;
    }

    public function getW(): float
    {
        return $this->w;
    }

    public function getType(): string
    {
        return TypeTuple::getTypeByValue($this->w);
    }

    public function add(TupleInterface $tuple): void
    {
        $this->x += $tuple->getX();
        $this->y += $tuple->getY();
        $this->z += $tuple->getZ();
        $this->w = ($tuple->getW() + $this->w > 0) ? 1 : 0;
    }

    public function substr(TupleInterface $tuple): void
    {
        $this->x -= $tuple->getX();
        $this->y -= $tuple->getY();
        $this->z -= $tuple->getZ();
        $this->w = abs($this->w - $tuple->getW());
    }

    public function negate(): void
    {
        $this->x = -$this->x;
        $this->y = -$this->y;
        $this->z = -$this->z;
        $this->w = -$this->w;
    }

    public function multiplyBy(float $factor): self
    {
        return new self(
            $factor * $this->x,
            $factor * $this->y,
            $factor * $this->z,
            $factor * $this->w
        );
    }

    public function dividingBy(float $coef): void
    {
        $this->x /= $coef;
        $this->y /= $coef;
        $this->z /= $coef;
        $this->w /= $coef;
    }

    public function getMagnitude(): float
    {
        return
            sqrt(
                ($this->x * $this->x) +
                ($this->y * $this->y) +
                ($this->z * $this->z) +
                ($this->w * $this->w)
            )
        ;
    }

    public function normalize(): void
    {
        $magnitude = $this->getMagnitude();
        $this->x = $this->x / $magnitude;
        $this->y = $this->y / $magnitude;
        $this->z = $this->z / $magnitude;
        $this->w = $this->w / $magnitude;
    }

    public function dot(TupleInterface $tuple): float
    {
        return ($this->x * $tuple->getX()) +
            ($this->y * $tuple->getY()) +
            ($this->z * $tuple->getZ()) +
            ($this->w * $tuple->getW())
        ;
    }

    public function cross(TupleInterface $tuple): TupleInterface
    {
        return new Tuple(
            $this->x * $tuple->getY() - $this->y * $tuple->getX(),
            $this->y * $tuple->getZ() - $this->z * $tuple->getY(),
            $this->z * $tuple->getX() - $this->x * $tuple->getZ(),
            TypeTuple::VECTOR
        );
    }

    public static function from(float $x, float $y, float $z, float $w): self
    {
        return new self($x, $y, $z, $w);
    }

    public function equalTo(TupleInterface $that): bool
    {
        if (false === Comparator::float($this->x, $that->getX())) {
            return false;
        }

        if (false === Comparator::float($this->y, $that->getY())) {
            return false;
        }

        if (false === Comparator::float($this->z, $that->getZ())) {
            return false;
        }

        return true;
    }

    public function plus(self $that): self
    {
        if ($this->isPoint() && $that->isPoint()) {
            throw new RuntimeException('Cannot add point tuple to another point tuple');
        }

        return new self(
            $this->x + $that->getX(),
            $this->y + $that->getY(),
            $this->z + $that->getZ(),
            $this->w + $that->getW()
        );
    }

    public function isPoint(): bool
    {
        return 1.0 === $this->w;
    }

    public function isVector(): bool
    {
        return 0.0 === $this->w;
    }

    public function minus(self $that): self
    {
        if ($this->isVector() && $that->isPoint()) {
            throw new RuntimeException('Cannot subtract point tuple from a vector tuple');
        }

        return new self(
            $this->x - $that->getX(),
            $this->y - $that->getY(),
            $this->z - $that->getZ(),
            $this->w - $that->getW()
        );
    }
}
