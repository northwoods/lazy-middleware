# Northwoods Lazy Middleware

[![Build Status](https://travis-ci.org/northwoods/lazy-middleware.svg?branch=develop)](https://travis-ci.org/northwoods/lazy-middleware)
[![Code Quality](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/?branch=master)
[![Latest Stable Version](http://img.shields.io/packagist/v/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)
[![Total Downloads](https://img.shields.io/packagist/dt/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)
[![License](https://img.shields.io/packagist/l/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)

Lazy middleware factory that supports "just in time" instantiation of middleware
using a [PSR-11][psr-container] [container][containers].

[psr-container]: https://www.php-fig.org/psr/psr-11/
[containers]: https://packagist.org/providers/psr/container-implementation

## Installation

The best way to install and use this package is with [composer](http://getcomposer.org/):

```shell
composer require northwoods/lazy-middleware
```

## Usage

```php
use Northwoods\Middleware\LazyMiddlewareFactory;

/** @var ContainerInterface */
$container = /* any container */;

// Create a new factory
$factory = new LazyMiddlewareFactory($container);

// Create a new lazy middleware
$middleware = $factory->defer(Acme\Middleware::class);
```

The created `$middleware` instance will wait until the `process()` method is
called and then resolve the proxied middleware and call its `process()` method.

It is also possible to create lazy middleware instances directly:

```php
use Northwoods\Middleware\LazyMiddleware;

/** @var ContainerInterface */
$container = /* any container */;

$middleware = new LazyMiddleware($container, Acme\Middleware::class);
```

Generally the factory is preferred as it reduces the amount of code required.
