<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Northwoods\Middleware\Fixture\Middleware;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class LazyMiddlewareFactoryTest extends TestCase
{
    /** @var LazyMiddlewareFactory */
    private $factory;

    public function setUp()
    {
        $container = new class implements ContainerInterface
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

        $this->factory = new LazyMiddlewareFactory($container);
    }

    public function testCreatesProxyMiddleware(): void
    {
        $middleware = $this->factory->defer(Middleware::class);

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
    }
}
