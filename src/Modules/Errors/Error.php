<?php

namespace YannLo\Agl\Modules\Errors;

use YannLo\Agl\Framework\Module;
use YannLo\Agl\Renderer\RendererInterface;

class Error extends Module
{
    public function __construct(RendererInterface $renderer)
    {
        $renderer -> addPath(__DIR__ . '/views', "Error");
    }
}
