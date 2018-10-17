<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use InvalidArgumentException;
use Northwoods\Middleware\Fixture\Handler;
use Northwoods\Middleware\Fixture\Middleware;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class LazyMiddlewareTest extends TestCase
{
    /** @var ContainerInterface */
    private $container;

    public function setUp()
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

    public function testVerifiesMiddlewareImplementation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(self::class);

        $middleware = new LazyMiddleware($this->container, self::class);
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
