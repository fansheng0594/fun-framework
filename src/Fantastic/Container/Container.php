<?php

namespace Fantastic\Container;

use Closure;
use Fantastic\Contracts\Container\Container as ContainerContract;
use ArrayAccess;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ArrayAccess, ContainerContract
{
    protected static $instance;
    protected $aliases = [];
    protected $abstractAliases = [];
    protected $instances = [];
    protected $bindings = [];

    public function instance($abstract, $instance)
    {
        $this->removeAbstractAlias($abstract);

        $isBound = $this->bound($abstract);

        unset($this->aliases[$abstract]);

        $this->instances[$abstract] = $instance;

        if ($isBound) {
            $this->reBound($abstract);
        }

        return $instance;
    }

    protected function removeAbstractAlias($searched)
    {
        if (! isset($this->aliases[$searched])) {
            return;
        }

        foreach ($this->abstractAliases as $abstract => $aliases) {
            foreach ($aliases as $index => $alias) {
                if ($alias == $searched) {
                    unset($this->abstractAliases[$abstract][$index]);
                }
            }
        }
    }

    public function bound($abstract)
    {
        return isset($this->bindings[$abstract]) ||
            isset($this->instances[$abstract]) ||
            $this->isAlias($abstract);
    }

    protected function isAlias($name)
    {
        return isset($this->aliases[$name]);
    }

    protected function reBound($abstract)
    {
        var_dump('rebound not work');
        die;
        // TODO rebound 较早涉及到 make，所以先放着，之后用到了 make 再写
    }

    public static function setInstance($container = null)
    {
        return static::$instance = $container;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function alias($abstract, $alias)
    {
        // TODO: Implement alias() method.
    }

    public function tag($abstracts, $tags)
    {
        // TODO: Implement tag() method.
    }

    public function tagged($tag)
    {
        // TODO: Implement tagged() method.
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bind() method.
    }

    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bindIf() method.
    }

    public function singleton($abstract, $concrete = null)
    {
        // TODO: Implement singleton() method.
    }

    public function singletonIf($abstract, $concrete = null)
    {
        // TODO: Implement singletonIf() method.
    }

    public function extend($abstract, Closure $closure)
    {
        // TODO: Implement extend() method.
    }

    public function addContextualBinding($concrete, $abstract, $implementation)
    {
        // TODO: Implement addContextualBinding() method.
    }

    public function when($concrete)
    {
        // TODO: Implement when() method.
    }

    public function factory($abstract)
    {
        // TODO: Implement factory() method.
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }

    public function make($abstract, array $parameters = [])
    {
        // TODO: Implement make() method.
    }

    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        // TODO: Implement call() method.
    }

    public function resolved($abstract)
    {
        // TODO: Implement resolved() method.
    }

    public function resolving($abstract, Closure $callback = null)
    {
        // TODO: Implement resolving() method.
    }

    public function afterResolving($abstract, Closure $callback = null)
    {
        // TODO: Implement afterResolving() method.
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function has($id)
    {
        // TODO: Implement has() method.
    }
}
