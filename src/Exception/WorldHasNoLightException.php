<?php

declare(strict_types=1);

namespace Raytracer\Exception;

use RuntimeException;
use Throwable;

final class WorldHasNoLightException extends RuntimeException implements Throwable
{
}
