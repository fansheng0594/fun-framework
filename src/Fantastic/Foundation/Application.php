<?php

namespace Fantastic\Foundation;

use Fantastic\Container\Container;
use Fantastic\Foundation\Mix;

class Application extends Container
{
    protected $basePath;
    protected $appPath;
    protected $storagePath;
    protected $databasePath;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
    }

    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathInContainer();

        return $this;
    }

    protected function bindPathInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }

    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'app';

        return $appPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function basePath($path = '')
    {
        return $this->basePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function langPath($path = '')
    {
        return $this->resourcePath().DIRECTORY_SEPARATOR.'lang';
    }

    public function resourcePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'resources'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    protected function registerBaseBindings()
    {
        // Why not 为什么这里就直接 set instance 了
        static::setInstance($this);

        // Why not 这两个 instance 有什么用
        $this->instance('app', $this);

        $this->instance(Container::class, $this);
        $this->singleton(Mix::class);
    }
}
