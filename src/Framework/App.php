<?php

namespace YannLo\Agl\Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * App
 *
 * associates modules with the application or the platform
 */
class App implements RequestHandlerInterface
{
    /**
     * modules
     *
     * @var Module[] modules
     */
    private array $modules;

    /**
     * middlewares
     *
     * @var middlewareInterface middlewares
     */
    private array $middlewares = [];




    /**
     * __construct
     *
     * @param  ContainerInterface $containt
     * @param  string[] $modules
     * @return void
     */
    public function __construct(private ContainerInterface $container, array $modules = [])
    {
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }


    /**
     * pipe
     *
     * Add middleware to execute in app
     *
     * @param  MiddlewareInterface|string $middleware
     * @return self
     */
    public function pipe(MiddlewareInterface|string $middleware): self
    {
        if ($middleware instanceof MiddlewareInterface) {
            $this->middlewares[] = $middleware;
            return $this;
        }

        $this->middlewares[] = $this -> container -> get($middleware);
        return $this;
    }


    /**
     * handle
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middlewares)) {
            return new Response();
        }

        $middleware = array_shift($this->middlewares);

        return $middleware->process($request, $this);
    }
}
