<?php

declare(strict_types=1);

namespace Raytracer\Exception;

use RuntimeException;
use Throwable;

final class IntersectionHasNoHitException extends RuntimeException implements Throwable
{
}
