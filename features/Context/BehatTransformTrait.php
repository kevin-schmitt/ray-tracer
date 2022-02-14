<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

/**
 * To use in class extends behat context.
 */
trait BehatTransformTrait
{
    /**
     * @Transform /^(\d+)$/
     */
    public function castStringToNumber(string $string): float
    {
        return floatval($string);
    }
}
