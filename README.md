# Simple implementation of the Dependency Injection container

[![Build Status](https://travis-ci.org/awd-studio/di.svg?branch=master)](https://travis-ci.org/awd-studio/di)
[![Coverage Status](https://coveralls.io/repos/github/awd-studio/DI/badge.svg?branch=master)](https://coveralls.io/github/awd-studio/DI?branch=master)

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

// Factory method
$registry->register(MyService1::class)
         ->factory(MyStatic::class, 'factoryMethodName', [
             'Simple Argument', 
             '@my.second.service'
         ]);

// Static factory method
$registry->register(MyService1::class)
         ->fromCallable([MyStatic::class, 'build']);
//         ->fromCallable(['\Full\Namespace\MyStatic', 'build']);

// Common function
$registry->register(MyService1::class)
         ->fromCallable('callableFunction');
         
// Closure factory
$registry->register(MyService1::class)
         ->fromCallable(function ($arg) {
             return new MyService1($arg);
         })
         ->arguments(['My argument']);
```

## Testing:
```bash
composer test
```
