<?php


namespace YannLo\Agl\Tests\Framework\Renderer;

use Twig\Environment;
use PHPUnit\Framework\TestCase;
use Twig\Loader\FilesystemLoader;
use YannLo\Agl\Renderer\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function setUp(): void
    {
        $loader =new FilesystemLoader(dirname(dirname(__DIR__))."/views");

        $twig = new Environment($loader);

        $this -> TwigRenderer = new TwigRenderer($loader, $twig);
    }

    public function testGetRender(): void
    {
        $renderer = $this -> TwigRenderer;

        $render = $renderer -> render("layout");
        $this -> assertEquals("Mon layout ", $render);

    }

    public function testAddPath(): void
    {
        $renderer = $this -> TwigRenderer;
        $renderer -> addPath(__DIR__."/views");

        $render = $renderer -> render("demo");
    
        $this -> assertEquals("Page de demo ", $render);

    }

    public function testGetRenderWithParams(): void
    {
        $renderer = $this -> TwigRenderer;
        $renderer -> addPath(__DIR__."/views");

        $render = $renderer -> render("demo",["ok"=>"valider"]);
    
        $this -> assertEquals("Page de demo valider", $render);
    }


    public function testAddPathWithNamespace(): void
    {
        $renderer = $this -> TwigRenderer;
        $renderer -> addPath(__DIR__."/views", "Demo");

        $render = $renderer -> render("@Demo/demo");
    
        $this -> assertEquals("Page de demo ", $render);
    }

    public function testAddGlobals(): void
    {
        $renderer = $this -> TwigRenderer;
        $renderer -> addPath(__DIR__."/views");

        $renderer -> addGlobal("ok", "valider");
        
        $render = $renderer -> render("demo");
        $this -> assertEquals("Page de demo valider", $render);

        $render = $renderer -> render("layout");
        $this -> assertEquals("Mon layout valider", $render);
    }




}