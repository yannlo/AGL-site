<?php

namespace YannLo\Basic\Modules\Declarations;

use YannLo\Basic\Router\Router;
use YannLo\Basic\Framework\Module;
use Psr\Container\ContainerInterface;
use YannLo\Basic\Renderer\RendererInterface;
use YannLo\Basic\Modules\Declarations\Action\DeclarationAction;

class Declaration extends Module
{
    public const DEFINITIONS = __DIR__ . '/config.php';

    public const MIGRATIONS = null;

    public const SEEDS = null;

    public function __construct(private ContainerInterface $container, string $prefix)
    {
        $renderer = $this -> container -> get(RendererInterface::class);
        $routers = $this -> container -> get(Router::class);
        $action = $this -> container -> get(DeclarationAction::class);
        
        $userRouter = $routers['user']; 
        
        $renderer -> addPath(__DIR__ . '/views',"Declaration");

        if($prefix=="/")
        {
            $prefix ="";
        }

        $userRouter -> get(
            path: $prefix."[/pg-{page:\d+}]",
            middleware: $action,
            name: "declaration.index"
        );

        $userRouter -> get(
            path: $prefix."/create",
            middleware: $action,
            name: "declaration.create",
            methods: ["GET", "POST"]
        );

        $userRouter -> get(
            path: $prefix."/{slug:[0-9a-z\-]+}-{id:[0-9]+}",
            middleware: $action,
            name: "declaration.show"
        );

        $userRouter -> get(
            path: $prefix."/{slug:[0-9a-z\-]+}-{id:[0-9]+}/update",
            middleware: $action,
            name: "declaration.update",
            methods: ["GET", "POST"]
        );

        $userRouter -> get(
            path: $prefix."/{slug:[0-9a-z\-]+}-{id:[0-9]+}/delete",
            middleware: $action,
            name: "declaration.delete",
            methods: ["GET", "POST"]
        );

    }
}