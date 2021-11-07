<?php

namespace YannLo\Agl\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{

    public function __construct(private FilesystemLoader $loader, private Environment $twig)
    {
    }


    /**
     * addPath
     *
     * @param  string $path
     * @param  string|null $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        if ($namespace == null) {
            $this->loader->addPath($path);
            return;
        }

        $this->loader->addPath($path, $namespace);
    }



    /**
     * addGlobal
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this->twig->addGlobal($key, $value);
    }



    /**
     * render
     *
     * @param  mixed $view
     * @param  mixed $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return $this -> twig -> render($view . ".twig", $params);
    }
}
