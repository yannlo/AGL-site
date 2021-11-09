<?php

use YannLo\Basic\Modules\Declarations\Declaration;

use function DI\autowire;
use function DI\get;

return [
    "declaration.prefix" => "/declarations",
    Declaration::class => autowire() -> constructorParameter("prefix", get("declaration.prefix"))
];