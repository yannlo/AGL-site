<?php

namespace YannLo\Agl\Router;

use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route as MezzioRoute;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router
{


    /**
     * router
     *
     * @var FastRouteRouter $router
     */
    private FastRouteRouter $router;

    /**
     * router
     *
     * @var Route[] $routes
     */
    private array $routes;



    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * get
     *
     * @param  string $path
     * @param  MiddlewareInterface $middleware
     * @param  string $name
     * @param  string[] $methods
     *
     * @return void
     */
    public function get(
        string $path,
        MiddlewareInterface $middleware,
        string $name,
        array $methods = ["GET"]
    ): void {
        $this->routes[] = new Route($name, $middleware, [], $path);
        $this -> router->addRoute(new MezzioRoute(
            path: $path,
            middleware: $middleware,
            methods: $methods,
            name: $name
        ));
    }


    /**
     * match
     *
     * @param  ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedRoute()->getMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    /**
     * generateUri
     *
     * @param  string $name
     * @param  string $params
     * @return string
     */
    public function generateUri(string $name, array $params): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        return $uri;
    }

    /**
     * getRoutes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * getRoute
     *
     * @param  string $name
     * @return Route|null
     */
    public function getRoute(string $name): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->getName() == $name) {
                return $route;
            }
        }
        return null;
    }
}
