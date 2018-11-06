# Northwoods Lazy Middleware

[![Build Status](https://travis-ci.com/northwoods/lazy-middleware.svg?branch=master)](https://travis-ci.com/northwoods/lazy-middleware)
[![Code Quality](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/northwoods/lazy-middleware/?branch=master)
[![Latest Stable Version](http://img.shields.io/packagist/v/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)
[![Total Downloads](https://img.shields.io/packagist/dt/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)
[![License](https://img.shields.io/packagist/l/northwoods/lazy-middleware.svg?style=flat)](https://packagist.org/packages/northwoods/lazy-middleware)

Lazy loading for [PSR-15 middleware and request handlers][psr15] that supports
"just in time" instantiation using a [PSR-11][psr11] [container][containers].

[psr15]: https://www.php-fig.org/psr/psr-15/
[psr11]: https://www.php-fig.org/psr/psr-11/
[containers]: https://packagist.org/providers/psr/container-implementation

## Installation

The best way to install and use this package is with [composer](http://getcomposer.org/):

```shell
composer require northwoods/lazy-middleware
```

## Usage

This package contains two factories: one for request handlers and one for middleware.

### LazyHandlerFactory::defer($handler)

Create a new lazy handler.

The `$handler` identifier is *not* required to be a class name. Any string
that refers to a container identifier can be used.

```php
use Northwoods\Middleware\LazyHandlerFactory;

/** @var ContainerInterface */
$container = /* any container */;

$lazyHandler = new LazyHandlerFactory($container);

/** @var \Psr\Http\Server\RequestHandlerInterface */
$handler = $lazyHandler->defer(Acme\FooHandler::class);
```

### LazyMiddlewareFactory::defer($middleware)

Create a new lazy middleware.

The `$middleware` identifier is *not* required to be a class name. Any string
that refers to a container identifier can be used.

```php
use Northwoods\Middleware\LazyMiddlewareFactory;

/** @var ContainerInterface */
$container = /* any container */;

$lazyMiddleware = new LazyMiddlewareFactory($container);

/** @var \Psr\Http\Server\MiddlewareInterface */
$middleware = $lazyMiddleware->defer(Acme\BarMiddleware::class);
```
