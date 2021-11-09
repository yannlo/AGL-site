<?php


namespace YannLo\Basic\Modules\Declarations\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use YannLo\Basic\Modules\Declarations\Models\DeclarationManager;
use YannLo\Basic\Renderer\RendererInterface;

class DeclarationAction implements MiddlewareInterface
{
    use \YannLo\Basic\Modules\Tools\Action\ExtractPageTrait;

    public function __construct(
        private ContainerInterface $container,
        private DeclarationManager $manager
    )
    {

    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        $response = $handler->handle($request);

        $routeName = $request ->getAttribute("routeName");

        $page = $this -> extractRouteName($routeName);

        $data ["routeParams"] = $request -> getAttribute("routeParams");
        $data["response"] = $response;

        return $this -> $page($data);

    }

    private function index(array $data): ResponseInterface
    {
        $response = $data['response'];
        unset($data["response"]);

        $page = 1;

        if(isset($data['routeParams']['page']))
        {
            $page = $data['routeParams']['page'];
        }
        $data["declarations"]  = $this -> manager -> getAllByPage($page);

        $content = ($this -> container ->get(RendererInterface::class)) -> render("@Declaration/index", $data);
        $response -> getBody() -> write($content);
        return $response;
    }


    private function show(array $data): ResponseInterface
    {
        $response = $data['response'];
        unset($data["response"]);

    
        $data["declaration"] = $this -> manager -> getOnce($data["routeParams"]["id"]);
        

        $content = ($this -> container ->get(RendererInterface::class)) -> render("@Declaration/show", $data);
        $response -> getBody() -> write($content);
        return $response;
    }


    private function update(array $data): ResponseInterface
    {
        $response = $data['response'];
        unset($data["response"]);



        $content = ($this -> container ->get(RendererInterface::class)) -> render("@Declaration/update", $data);
        $response -> getBody() -> write($content);
        return $response;
    }


    private function create(array $data): ResponseInterface
    {
        $response = $data['response'];
        unset($data["response"]);



        $content = ($this -> container ->get(RendererInterface::class)) -> render("@Declaration/create", $data);
        $response -> getBody() -> write($content);
        return $response;
    }

    private function delete(array $data): ResponseInterface
    {
        $response = $data['response'];
        unset($data["response"]);



        $content = ($this -> container ->get(RendererInterface::class)) -> render("@Declaration/delete", $data);
        $response -> getBody() -> write($content);
        return $response;
    }
}