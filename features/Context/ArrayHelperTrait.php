<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

trait ArrayHelperTrait
{
    private function stringToArray(string $valueWithComaSeparator): array
    {
        return array_map('trim', explode(',', $valueWithComaSeparator));
    }

    private function stringToArrayFloat(string $valueWithComaSeparator): array
    {
        return array_map(function (string $value) {
            return floatval(preg_replace("/[^0-9\.-]/", "", $value));
        }, explode(',', $valueWithComaSeparator));
    }

    private function stringToArrayInt(string $valueWithComaSeparator): array
    {
        return array_map(function (string $value) {
            return intval(trim($value));
        }, explode(',', $valueWithComaSeparator));
    }
}
