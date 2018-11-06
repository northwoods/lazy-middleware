<?php
declare(strict_types=1);

namespace Northwoods\Middleware;

use InvalidArgumentException;
use Northwoods\Middleware\Fixture\Handler;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class LazyHandlerTest extends TestCase
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

    public function testVerifiesHandlerImplementation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(self::class);

        $handler = new LazyHandler($this->container, self::class);
    }

    public function testDefersToHandlerImplemention(): void
    {
        $handler = new LazyHandler($this->container, Handler::class);

        $request = new ServerRequest('GET', 'https://example.com/');

        $response = $handler->handle($request);

        $this->assertEquals(400, $response->getStatusCode());
    }
}
