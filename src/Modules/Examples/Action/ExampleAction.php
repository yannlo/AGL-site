<?php

namespace YannLo\Agl\Modules\Examples\Action;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use YannLo\Agl\Renderer\RendererInterface;
use YannLo\Agl\Modules\Examples\Models\ArticleManager;

class ExampleAction implements MiddlewareInterface
{
    use \YannLo\Agl\Modules\Tools\Action\ExtractPageTrait;

    public function __construct(
        private \PDO $pdo,
        private RendererInterface $renderer,
        private ArticleManager $manager
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeName = $request ->getAttribute("routeName");

        $page = $this -> extractRouteName($routeName);

        $data ["routeParams"] = $request -> getAttribute("routeParams");

        return $this -> $page($data);
    }

    private function index(array $data): ResponseInterface
    {
        $data["articles"] = $this -> manager -> getAll();
        return new Response(body: $this->renderer->render("@Example/index", $data));
    }

    private function show(array $data): ResponseInterface
    {
        $data["article"] = $this -> manager -> getOnce($data["routeParams"]["id"]);

        if ($data['routeParams']['slug'] != $data["article"] -> slug()) {
            return (new Response(301)) -> withHeader("location", $data["article"]->slug() . "-" . $data["article"]->id());
        }

        return new Response(body: $this->renderer->render("@Example/show", $data));
    }
}
