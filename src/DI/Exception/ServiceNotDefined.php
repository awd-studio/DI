<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Exception;

use Psr\Container\NotFoundExceptionInterface;

final class ServiceNotDefined extends DIException implements NotFoundExceptionInterface {}
