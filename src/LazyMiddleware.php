<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use InvalidArgumentException;
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
        if (! is_subclass_of($middleware, MiddlewareInterface::class, true)) {
            throw new InvalidArgumentException(
                sprintf('%s does not implement %s', $middleware, MiddlewareInterface::class)
            );
        }

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
