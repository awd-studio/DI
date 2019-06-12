<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Exception;

use Psr\Container\ContainerExceptionInterface;

final class UnknownServiceType extends DIException implements ContainerExceptionInterface {}
