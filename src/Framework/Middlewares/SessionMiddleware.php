<?php

namespace YannLo\Agl\Middlewares;

use YannLo\Agl\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        
        $session =  $this -> initializeSession();

        $request = $request -> withAttribute("session",$session);

        $response = $handler->handle($request);

        $session = $request -> getAttribute("session");

        $this -> persistSession($session);

        return $response;
    }

    private function initializeSession(): Session
    {
        session_start();

        return new Session($_SESSION);
    }

    private function persistSession(session $session): void
    {
        $_SESSION = $session -> sessionArray();
    }
}