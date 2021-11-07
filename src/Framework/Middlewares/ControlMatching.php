<?php

namespace YannLo\Agl\Middlewares;

use GuzzleHttp\Psr7\Response;
use YannLo\Agl\Framework\App;
use YannLo\Agl\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use YannLo\Agl\Renderer\RendererInterface;

/**
 * ControlMatching
 *
 * return page if matching is tue and return 404 page also
 */
class ControlMatching implements MiddlewareInterface
{


    /**
     * __construct
     *
     * @param  Router $router
     * @param  RendererInterface $renderer
     * @return void
     */
    public function __construct(private Router $router, private RendererInterface $renderer)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {


        $route = $this->router->match($request);

        if (is_null($route)) {
            $response = new Response();
            $content = $this -> renderer -> render("@Error/404");
            $response-> getBody() -> write($content);
            $response = $response->withStatus(404);

            return $response;
        }

        if ($handler instanceof App) {
            $handler -> pipe($route -> getMiddleware());
        } else {
            throw new \InvalidArgumentException('invalid handler class');
        }

        $request = $request -> withAttribute("routeName", $route->getName())
            -> withAttribute("routeParams", $route->getParams());


        return $handler->handle($request);
    }
}
