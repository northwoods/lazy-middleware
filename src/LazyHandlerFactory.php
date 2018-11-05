<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Psr\Container\ContainerInterface;

class LazyHandlerFactory
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create a lazy handler instance.
     */
    public function defer(string $handler): LazyHandler
    {
        return new LazyHandler($this->container, $handler);
    }
}
