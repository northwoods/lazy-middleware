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

    public function testDefersToHandlerImplementation(): void
    {
        $handler = new LazyHandler($this->container, Handler::class);

        $request = new ServerRequest('GET', 'https://example.com/');

        $response = $handler->handle($request);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailsIfContainerDoesNotHaveHandler(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid');

        new LazyHandler($this->container, 'invalid');
    }
}
