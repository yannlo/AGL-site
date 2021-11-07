<?php

namespace YannLo\Agl\Renderer;

interface RendererInterface
{
    /**
     * addPath
     *
     * Permite to add path to load view
     *
     * @param  string $path
     * @param  null|string $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void;


    /**
     * render
     *
     * permit to render views
     *
     * you can to get good path with the namespace
     *
     * $this->render(@namespace/view);
     *
     * $this->render(@view);
     * @param  string $view
     * @param  array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;


    /**
     * addGlobal
     *
     * permite to add global variables in all views
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void;
}
