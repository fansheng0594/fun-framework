<?php

namespace Fantastic\Foundation;

use Fantastic\Container\Container;
use Fantastic\Contracts\Foundation\Application as ApplicationContract;
use Fantastic\Events\EventServiceProvider;
use Fantastic\Filesystem\Filesystem;
use Fantastic\Foundation\Mix;
use Fantastic\Log\LogServiceProvider;
use Fantastic\Support\Arr;
use Fantastic\Support\ServiceProvider;

class Application extends Container implements ApplicationContract
{
    protected $basePath;
    protected $appPath;
    protected $storagePath;
    protected $databasePath;
    protected $serviceProviders = [];
    protected $loadProviders = [];
    protected $booted = false;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
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
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
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

        $this->singleton(PackageManifest::class, function (){
            return new PackageManifest(
                new Filesystem, $this->basePath(), $this->getCachedPackagesPath()
            );
        });
    }

    protected function getCachedPackagesPath()
    {
        var_dump('method getCachedPackagesPath todo');
        die;
    }

    /**
     * 注册所有的基础服务提供者
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));
        $this->register(new LogServiceProvider($this));
    }

    public function version()
    {
        // TODO: Implement version() method.
    }

    public function environment(...$environments)
    {
        // TODO: Implement environment() method.
    }

    public function runningInConsole()
    {
        // TODO: Implement runningInConsole() method.
    }

    public function runningUnitTests()
    {
        // TODO: Implement runningUnitTests() method.
    }

    public function isDownForMaintenance()
    {
        // TODO: Implement isDownForMaintenance() method.
    }

    public function registerConfiguredProviders()
    {
        // TODO: Implement registerConfiguredProviders() method.
    }

    /**
     * 在应用程序中注册服务提供者
     *
     * @param ServiceProvider|string $provider
     * @param bool $force
     * @return ServiceProvider|void
     */
    public function register($provider, $force = false)
    {
        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }

        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        $provider->register();

        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }

        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $key => $value) {
                $this->singleton($key, $value);
            }
        }

        $this->markAsRegistered($provider);

        if ($this->isBooted()) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    public function registerDeferredProvider($provider, $service = null)
    {
        // TODO: Implement registerDeferredProvider() method.
    }

    /**
     * 根据类名解析一个服务提供者
     *
     * @param string $provider
     * @return ServiceProvider
     */
    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    public function boot()
    {
        // TODO: Implement boot() method.
    }

    public function booting($callback)
    {
        // TODO: Implement booting() method.
    }

    public function booted($callback)
    {
        // TODO: Implement booted() method.
    }

    public function bootstrapWith(array $bootstrappers)
    {
        // TODO: Implement bootstrapWith() method.
    }

    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::where($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    public function hasBeenBootstrapped()
    {
        // TODO: Implement hasBeenBootstrapped() method.
    }

    public function loadDeferredProviders()
    {
        // TODO: Implement loadDeferredProviders() method.
    }

    public function setLocale($locale)
    {
        // TODO: Implement setLocale() method.
    }

    public function shouldSkipMiddleware()
    {
        // TODO: Implement shouldSkipMiddleware() method.
    }

    public function terminate()
    {
        // TODO: Implement terminate() method.
    }

    /**
     * @param ServiceProvider|string $provider
     * @return mixed|null
     */
    protected function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    /**
     * @param ServiceProvider $provider
     * @return void
     */
    protected function markAsRegistered(ServiceProvider $provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadProviders[get_class($provider)] = true;
    }

    /**
     * 确定应用程序是否已经启动
     *
     * @retuen bool
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * 初始化给定的服务容器提供者
     *
     * @param ServiceProvider $provider
     * @return void
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        $provider->callBootingCallbacks();
        if (method_exists($provider, 'boot')) {
            $this->call([$provider, 'boot']);
        }

        $provider->callBootedCallbacks();
    }
}
