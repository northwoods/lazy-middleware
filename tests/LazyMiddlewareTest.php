<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Northwoods\Middleware\Fixture\Handler;
use Northwoods\Middleware\Fixture\Middleware;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class LazyMiddlewareTest extends TestCase
{
    /** @var ContainerInterface */
    private $container;

    protected function setUp(): void
    {
        $this->container = new class implements ContainerInterface
        {
            public function has($id)
            {
                return class_exists($id);
            }

            public function get($id)
            {
                return new $id();
            }
        };
    }

    public function testDefersToMiddlewareImplemention(): void
    {
        $middleware = new LazyMiddleware($this->container, Middleware::class);

        $handler = new Handler();
        $request = new ServerRequest('GET', 'https://example.com/');

        $response = $middleware->process($request, $handler);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(Middleware::class, (string) $response->getBody());
    }
}
