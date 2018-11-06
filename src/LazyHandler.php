<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyHandler implements RequestHandlerInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $handler;

    public function __construct(ContainerInterface $container, string $handler)
    {
        $this->container = $container;
        $this->handler = $handler;
    }

    // RequestHandlerInterface
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resolve()->handle($request);
    }

    private function resolve(): RequestHandlerInterface
    {
        return $this->container->get($this->handler);
    }
}
