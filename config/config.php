<?php

use function DI\get;
use function DI\create;
use function DI\string;
use function DI\factory;

use YannLo\Agl\Router\Router;
use YannLo\Agl\Renderer\RendererInterface;
use YannLo\Agl\Renderer\TwigRendererFactory;

return [

    // database config
    "database.host" => "localhost",
    "database.username" => "yannlo",
    "database.password" => "YannLo@01",
    "database.name" => "agl_site",

    // default view config
    'views.layouts_path' => dirname(__DIR__) . "/src/views",

    // basic class
        // router
    Router::class => create(),

        // renderer
    RendererInterface::class => factory(TwigRendererFactory::class),

        //database connection
    \PDO::class => create() -> constructor(string('mysql:dbname={database.name};host={database.host}'),
        get('database.username'),
        get('database.password'),
        [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]
    ),
];