<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Exception;

use Psr\Container\ContainerExceptionInterface;

final class ServiceRunException extends DIException implements ContainerExceptionInterface {}
