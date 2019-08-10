<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function sprintf;

class LazyMiddleware implements MiddlewareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $middleware;

    public function __construct(ContainerInterface $container, string $middleware)
    {
        if ($container->has($middleware) === false) {
            throw new InvalidArgumentException(sprintf('Container is missing middleware "%s"', $middleware));
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
