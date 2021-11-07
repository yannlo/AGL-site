<?php

namespace YannLo\Agl\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Route
 *
 * A matched route model
 */
class Route
{


    /**
     * __construct
     *
     * @var string $name;
     * @var MiddlewareInterface $middleware;
     * @var array $parameters;
     *
     * @return void
     */
    public function __construct(
        private string $name,
        private MiddlewareInterface $middleware,
        private array $parameters,
        private ?string $path = null
    ) {
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * getMiddleware
     *
     * @return MiddlewareInterface
     */
    public function getMiddleware(): MiddlewareInterface
    {
        return $this->middleware;
    }

    /**
     * get url list parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }

    /**
     * getPath
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }
}
