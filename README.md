# Simple implementation of the Dependency Injection container

[![Build Status](https://travis-ci.org/awd-studio/DI.svg?branch=master)](https://travis-ci.org/awd-studio/DI)
[![Coverage Status](https://coveralls.io/repos/github/awd-studio/DI/badge.svg)](https://coveralls.io/github/awd-studio/DI)

## Usage:

```php
<?php

use \Acme\Services\MyService1;
use \Acme\Services\MyService2;
use \Acme\Services\MyService2Factory;
use \Acme\Services\MyService3;
use \AwdStudio\DI\Storage\Registry;
use \AwdStudio\DI\ContainerFactory;

// Create a new registry
$registry = new Registry();

// Builds the container
$container = ContainerFactory::build($registry);

// Minimum service registration
$registry->register(MyService1::class);

// Named service
$registry->register('my.second.service')
         ->class(MyService2::class)
         ->factory(MyService2Factory::class, 'build', []);

// Service with arguments
$registry->register('my.service')
         ->class(MyService2::class) // Service interface or class
         ->arguments([              // Arguments for the construct the service
             'Simple Argument',     // Raw parameter
             '\!skip',              // Argument to skip
             '@my.second.service',  // Another named service
         ]);

// Check service existing
$container->has('@my.second.service');

// Fetch a service
$container->get('@my.second.service');
$container->get(MyService2::class);

// ToDo: Add static factories

// Static factory method
$registry->register(MyService1::class)
         ->function([MyStatic::class . '::build']);

// Common function
$registry->register(MyService1::class)
         ->function('callableFunction');
         
// Closure factory
$registry->register(MyService1::class)
         ->function(function ($arg) {
             return new MyService1($arg);
         })
         ->arguments(['My argument']);
```

## Testing:
```bash
composer test
```
