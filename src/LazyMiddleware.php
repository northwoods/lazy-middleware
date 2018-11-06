<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyMiddleware implements MiddlewareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $middleware;

    public function __construct(ContainerInterface $container, string $middleware)
    {
        $this->container = $container;
        $this->middleware = $middleware;
    }

    // MiddlewareInterface
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->resolve()->process($request, $handler);
    }

    private function resolve(): MiddlewareInterface
    {
        return $this->container->get($this->middleware);
    }
}
