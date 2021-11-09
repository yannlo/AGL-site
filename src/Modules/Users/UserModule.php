<?php

namespace YannLo\Agl\Modules\Users;

use phpDocumentor\Reflection\Types\Null_;
use YannLo\Agl\Router\Router;
use YannLo\Agl\Framework\Module;
use Psr\Container\ContainerInterface;
use YannLo\Agl\Renderer\RendererInterface;
use YannLo\Agl\Modules\Users\Action\UserAction;

class UserModule extends Module {

    public const MIGRATIONS =__DIR__ . '/db/migrations';

    public const SEEDS =__DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container) {

        $renderer = $container -> get(RendererInterface::class);
        $routers = $container -> get(Router::class);
        $userRouter = $routers["user"];

        $action = $container -> get(UserAction::class);

        $renderer-> addPath(__DIR__."/views", "User");

        $userRouter -> get(
            "/",
            $action,
            "user.index",
        );

        $userRouter -> get(
            "/login",
            $action,
            "user.login",
            ["GET", "POST"]
        );

        $userRouter -> get(
            "/sign-up",
            $action,
            "user.signup",
            ["GET", "POST"]
        );

        $userRouter -> get(
            "/account",
            $action,
            "user.account"
        );

        $userRouter -> get(
            "/logout",
            $action,
            "user.logout"
        );

        $userRouter -> get(
            "/update",
            $action,
            "user.update",
            ["GET", "POST"]
        );

        $userRouter -> get(
            "/delete",
            $action,
            "user.delete",
            ["GET", "POST"]
        );

    }


}