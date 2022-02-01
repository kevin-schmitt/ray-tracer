<?php

declare(strict_types=1);

namespace RayTracer\Intersection;

use OutOfBoundsException;
use Raytracer\Exception\IntersectionHasNoHitException;

final class IntersectionCollection
{
    public static function from(Intersection ...$intersections): static
    {
        usort(
            $intersections,
            static function (Intersection $a, Intersection $b): int {
                return $a->t() <=> $b->t();
            }
        );

        $hit = null;

        foreach ($intersections as $intersection) {
            if ($intersection->t() > 0) {
                $hit = $intersection;

                break;
            }
        }

        return new self($intersections, $hit);
    }

    /**
     * @param array<Intersection> $intersections
     */
    private function __construct(private array $intersections, private ?Intersection $hit)
    {
    }

    /**
     * @return array<Intersection>
     */
    public function asArray(): array
    {
        return $this->intersections;
    }

    /**
     * @throws OutOfBoundsException
     */
    public function at(int $position): Intersection
    {
        if (!isset($this->intersections[$position])) {
            throw new OutOfBoundsException();
        }

        return $this->intersections[$position];
    }

    public function count(): int
    {
        return count($this->intersections);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    public function hasHit(): bool
    {
        return null !== $this->hit;
    }

    public function hit(): Intersection
    {
        if (false === $this->hasHit()) {
            throw new IntersectionHasNoHitException();
        }

        //@phpstan-ignore-next-line
        return $this->hit;
    }
}
