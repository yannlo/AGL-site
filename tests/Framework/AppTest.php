<?php

namespace YannLo\Agl\Tests\Framework;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function setUp(): void
    {
        $this-> buidler = new ContainerBuilder();
        $this -> container = $this -> builder->build();

    }
}