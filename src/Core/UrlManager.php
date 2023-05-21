<?php

namespace Guynoolla\App\Core;

class UrlManager
{
    protected $cssPath;
    protected $jsPath;

    function __construct(string $urlBase, $settings)
    {
        $this->urlBase = $urlBase;
        $this->cssPath = $settings['css'];
        $this->jsPath = $settings['js'];
    }

    public function css(string $path)
    {
        return $this->urlBase . ltrim($this->cssPath, "/") . '/' . ltrim($path, "/") . '.css';
    }

    public function js(string $path)
    {
        return $this->urlBase . ltrim($this->jsPath, "/") . '/' . ltrim($path, "/") . '.js';
    }

    public function action(string $path)
    {
        return $this->urlBase . ltrim($path, "/");
    }
}
