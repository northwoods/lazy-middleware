<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Psr\Container\ContainerInterface;

class LazyMiddlewareFactory
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create a lazy middleware instance
     */
    public function defer(string $middleware): LazyMiddleware
    {
        return new LazyMiddleware($this->container, $middleware);
    }
}
