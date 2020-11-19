<?php

namespace Fantastic\Routing;

use Closure;
use Fantastic\Container\Container;
use Fantastic\Contracts\Events\Dispatcher;
use Fantastic\Contracts\Routing\BindingRegistrar;
use Fantastic\Contracts\Routing\Registrar as RegistrarContract;

class Router implements BindingRegistrar, RegistrarContract
{
    /**
     * @var Dispatcher
     */
    protected $events;
    /**
     * @var RouteCollectionInterface
     */
    protected $routes;
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Dispatcher $events, Container $container = null)
    {
        $this->events = $events;
        $this->routes = new RouteCollection;
        $this->container = $container ?: new \Fantastic\Container\Container();
    }

    public function bind($key, $binder)
    {
        // TODO: Implement bind() method.
    }

    public function getBindingCallback($key)
    {
        // TODO: Implement getBindingCallback() method.
    }

    public function get($uri, $action)
    {
        // TODO: Implement get() method.
    }

    public function post($uri, $action)
    {
        // TODO: Implement post() method.
    }

    public function put($uri, $action)
    {
        // TODO: Implement put() method.
    }

    public function delete($uri, $action)
    {
        // TODO: Implement delete() method.
    }

    public function patch($uri, $action)
    {
        // TODO: Implement patch() method.
    }

    public function options($uri, $action)
    {
        // TODO: Implement options() method.
    }

    public function match($methods, $uri, $action)
    {
        // TODO: Implement match() method.
    }

    public function resource($name, $controller, array $options = [])
    {
        // TODO: Implement resource() method.
    }

    public function group(array $attributes, $routes)
    {
        // TODO: Implement group() method.
    }

    public function substituteBindings($route)
    {
        // TODO: Implement substituteBindings() method.
    }

    public function substituteImplicitBindings($route)
    {
        // TODO: Implement substituteImplicitBindings() method.
    }
}
