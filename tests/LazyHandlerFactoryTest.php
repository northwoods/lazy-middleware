<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use Northwoods\Middleware\Fixture\Handler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyHandlerFactoryTest extends TestCase
{
    /** @var LazyHandlerFactory */
    private $factory;

    protected function setUp(): void
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

        $this->factory = new LazyHandlerFactory($container);
    }

    public function testCreatesProxyHandler(): void
    {
        $handler = $this->factory->defer(Handler::class);

        $this->assertInstanceOf(RequestHandlerInterface::class, $handler);
    }
}
