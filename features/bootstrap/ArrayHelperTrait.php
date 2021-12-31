<?php declare(strict_types=1);

namespace RayTracer\Tests;


trait ArrayHelperTrait {
    private function stringToArray(string $valueWithComaSeparator) : array
    {
        return array_map('trim', explode(',', $valueWithComaSeparator));
    }

    private function stringToArrayFloat(string $valueWithComaSeparator) : array
    {
        return array_map(function(string $value) {
            return floatval(trim($value));
        }, explode(',', $valueWithComaSeparator));
    }
}