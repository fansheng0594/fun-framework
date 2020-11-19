<?php

namespace Fantastic\Routing;

use Fantastic\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use InvalidArgumentException;

class UrlGenerator implements UrlGeneratorContract
{
    public function __construct(RouteCollectionInterface $routes, )
    {

    }

    public function current()
    {
        // TODO: Implement current() method.
    }

    public function previous($fallback = false)
    {
        // TODO: Implement previous() method.
    }

    public function to($path, $extra = [], $secure = null)
    {
        // TODO: Implement to() method.
    }

    public function secure($path, $parameters = [])
    {
        // TODO: Implement secure() method.
    }

    public function asset($path, $secure = null)
    {
        // TODO: Implement asset() method.
    }

    public function route($name, $parameters = [], $absolute = true)
    {
        // TODO: Implement route() method.
    }

    public function action($action, $parameters = [], $absolute = true)
    {
        // TODO: Implement action() method.
    }

    public function setRootControllerNamespace($rootNamespace)
    {
        // TODO: Implement setRootControllerNamespace() method.
    }
}
