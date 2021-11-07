<?php

namespace YannLo\Agl\Modules\Examples;

use YannLo\Agl\Router\Router;
use YannLo\Agl\Framework\Module;
use Psr\Container\ContainerInterface;
use YannLo\Agl\Renderer\RendererInterface;
use YannLo\Agl\Modules\Examples\Action\ExampleAction;

class Example extends Module
{

    /**
     * MIGRATION
     *
     * migration file path
     */
    public const MIGRATIONS = __DIR__ . '/db/migrations';

    /**
     * SEEDS
     *
     * seeds file path
     */
    public const SEEDS = __DIR__ . '/db/seeds';


    public function __construct(ContainerInterface $container)
    {
        $renderer = $container -> get(RendererInterface::class);

        $router = ($container -> get(Router::class))["user"];

        $action = $container -> get(ExampleAction::class);

        $renderer -> addPath(__DIR__ . "/views", "Example");

        $router -> get("/", $action, "example.index");
        $router -> get("/{slug:[a-z0-9\-]+}-{id:[0-9]+}", $action, "example.show");
    }
}
