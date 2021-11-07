<?php


namespace YannLo\Agl\Tests\Framework\router;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use YannLo\Agl\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use YannLo\Agl\Router\Route;

class RouterTest extends TestCase
{
    public function setUp(): void
    {
        $this -> router = new Router();
        $this -> middleware = new class implements MiddlewareInterface{
            public function process(ServerRequestInterface $server, RequestHandlerInterface $handler): ResponseInterface
            {
                return new Response(body: "Demo");
            } 
        };
    }


    public function testCorrectMatchingRoute(): void
    {
        $router = $this -> router;
        $router -> get("/demo", $this-> middleware ,"demo.index");
        $request = new ServerRequest("GET","/demo");
        $result = $router -> match($request);
        
        $this -> assertEquals("demo.index", $result->getName());
    }

    public function testCorrectMatchingRouteWithSlug(): void
    {
        $router = $this -> router;
        $router -> get("/demo/{slug:[a-z0-9]+\-[0-9]+}", $this-> middleware ,"demo.show");
        $request = new ServerRequest("GET","/demo/adazef-1364");
        $result = $router -> match($request);
        
        $this -> assertEquals("demo.show", $result->getName());
    }

    public function testErrorMatchingRoute(): void
    {
        $router = $this -> router;
        $router -> get("/demo", $this-> middleware ,"demo.index");
        $request = new ServerRequest("GET","/dadazef");
        $result = $router -> match($request);
        
        $this -> assertEquals(null,$result);
    }

    public function testGetSpecificRoute(): void
    {
        $router = $this -> router;
        $router -> get("/demo", $this-> middleware ,"demo.index");
        $router -> get("/demo/{slug:[a-z0-9]+\-[0-9]+}", $this-> middleware ,"demo.show");

        $route = $router -> getRoute("demo.index");
        $this -> assertEquals("demo.index",$route->getName());
    }

    public function testGetAllRoute(): void
    {
        $router = $this -> router;
        $router -> get("/demo", $this-> middleware ,"demo.index");
        $router -> get("/demo/{slug:[a-z0-9]+\-[0-9]+}", $this-> middleware ,"demo.show");

        $routes = $router -> getRoutes();
        $this -> assertEquals([
            new Route("demo.index",$this-> middleware ,[],"/demo"),
            new Route("demo.show",$this-> middleware ,[],"/demo/{slug:[a-z0-9]+\-[0-9]+}")
        ],$routes);
    }

    public function testWriteURI(): void
    {
        $router = $this -> router;
        $router -> get("/demo/{slug:[a-z0-9]+}-{id:[0-9]+}", $this-> middleware ,"demo.show");
        $uri = $router -> generateUri("demo.show",[
                "slug" => "aczer",
                "id" => "002"
        ]);

        $this -> assertEquals("/demo/aczer-002",$uri);
    }
}