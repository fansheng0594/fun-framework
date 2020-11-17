<?php

namespace Fantastic\Container;

use Closure;
use Fantastic\Contracts\Container\BindingResolutionException;
use Fantastic\Contracts\Container\Container as ContainerContract;
use ArrayAccess;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use TypeError;

class Container implements ArrayAccess, ContainerContract
{
    protected static $instance;
    protected $aliases = [];
    protected $abstractAliases = [];
    protected $instances = [];
    protected $bindings = [];
    protected $buildStack = [];
    protected $with;

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

    /**
     * 向容器注册绑定
     *
     * @param string $abstract
     * @param Closure|string|null $concrete
     * @param bool $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        $this->dropStaleInstances($abstract);

        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        if (! $concrete instanceof Closure) {
            if (! is_string($concrete)) {
                throw new TypeError(self::class.'::bind(): Argument #2 ($concrete) must be of type Closure|string|null');
            }

            $concrete = $this->getClosure($abstract, $concrete);
        }
    }

    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bindIf() method.
    }

    /**
     * 在容器中注册共享绑定（单例）
     *
     * @param string $abstract
     * @param null $concrete
     * @return void
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
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
        return $this->resolve($abstract, $parameters);
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

    /**
     * 删除所有旧的实例和别名
     *
     * @param string $abstract
     * @return void
     */
    protected function dropStaleInstances($abstract)
    {
        unset($this->instances[$abstract], $this->aliases[$abstract]);
    }

    /**
     * 获取生成类型时要使用的闭包
     * @param string $abstract
     * @param string $concrete
     * @return Closure
     */
    protected function getClosure($abstract, $concrete)
    {
        return function ($container, $parameters = []) use ($abstract, $concrete){
            if ($abstract == $concrete) {
                return $container->build($concrete);
            }

            return $container->resolve(
                $concrete, $parameters, $raiseEvents = false
            );
        };
    }

    /**
     * 实例化给定类型的具体实例
     * （该方法还在 getClosure 返回的闭包函数中调用到）
     *
     * @param Closure|string $concrete
     * @return mixed
     * @throws BindingResolutionException
     */
    public function build($concrete)
    {
        // TODO-John 现在还没用到 Closure 的 concrete，用到了再写这段
        if ($concrete instanceof Closure) {
            return $concrete($this, $this->getLastParameterOverride());
        }

        try {
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new BindingResolutionException("Target class [$concrete] does not exists.", 0, $e);
        }

        if (! $reflector->isInstantiable()) {
            return $this->notInstantiable($concrete);
        }

        $this->buildStack[] = $concrete;

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            array_pop($this->buildStack);

            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        try {
            $instances = $this->resolveDependencies($dependencies);
        } catch (BindingResolutionException $e) {
            array_pop($this->buildStack);

            throw $e;
        }


    }

    protected function getLastParameterOverride()
    {
        // Why not 因为我是在 getClosure 里跳转过来的，这样有个问题是
        // Closure 还未调用，我就写这些代码了，既然写到这那就继续吧，先做个记号，
        // 以后真正从 resolve 里执行时，知道 with 是什么意思，再删掉 我还有 why not
        return count($this->with) ? end($this->with) : [];
    }

    protected function notInstantiable($concrete)
    {
        if (! empty($this->buildStack)) {
            $previous = implode(', ', $this->buildStack);

            $message = "Target [$concrete] is not instantiable while building [$previous].";
        } else {
            $message = "Target [$concrete] is not instantiable";
        }

        throw new BindingResolutionException($message);
    }

    /**
     * @param ReflectionParameter[] $dependencies
     * @return array
     * @throws BindingResolutionException
     */
    protected function resolveDependencies(array $dependencies)
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            if ($this->hasParameterOverride($dependency)) {
                $results[] = $this->getParameterOverride($dependency);

                continue;
            }

            // 不是类的话，而是字符串等其他类型，抛错
            $result = is_null(Util::getParameterClassName($dependency))
                            ? $this->resolvePrimitive($dependency)
                            : $this->resolveClass($dependency);
        }


    }

    /**
     * 确定给定的依赖是否有参数覆盖
     *
     * @param ReflectionParameter $dependency
     * @return bool
     */
    protected function hasParameterOverride(ReflectionParameter $dependency)
    {
        return array_key_exists(
            $dependency->name, $this->getLastParameterOverride()
        );
    }

    protected function getParameterOverride(ReflectionParameter $dependency)
    {
        return $this->getLastParameterOverride()[$dependency->name];
    }

    /**
     * 解析一个非类的原生依赖项
     *
     * @param ReflectionParameter $parameter
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    protected function resolvePrimitive(ReflectionParameter $parameter)
    {
        // why not   contextual 里面都有 $ ？
        if (! is_null($concrete = $this->getContextualConcrete('$'.$parameter->getName()))) {
            return $concrete instanceof Closure ? $concrete($this) : $concrete;
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        $this->unresolvablePrimitive($parameter);
    }

    /**
     * 获取给定抽象的上下文具体绑定
     *
     * @param string $abstract
     * @return Closure|string|array|null
     */
    protected function getContextualConcrete($abstract)
    {
        if (! is_null($binding = $this->findInContextualBindings($abstract))) {
            return $binding;
        }

        if (empty($this->abstractAliases[$abstract])) {
            return;
        }

        foreach ($this->abstractAliases[$abstract] as $alias) {
            if (! is_null($binding = $this->findInContextualBindings($alias))) {
                return $binding;
            }
        }
    }

    /**
     * 在上下文绑定数组中找到给定抽象的具体绑定
     * @param $abstract
     * @return Closure|string|null
     */
    protected function findInContextualBindings($abstract)
    {
        // Why not contextual 是啥？
        return $this->contextual[end($this->buildStack)][$abstract] ?? null;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return void
     *
     * @throws BindingResolutionException
     */
    protected function unresolvablePrimitive(ReflectionParameter $parameter)
    {
        $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";

        throw new BindingResolutionException($message);
    }

    /**
     * 解析容器中基于类的依赖关系
     *
     * @param ReflectionParameter $parameter
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        try {
            // 查看参数是否是可变的
            return $parameter->isVariadic()
                        ? $this->resolveVariadicClass($parameter)
                        : $this->make(Util::getParameterClassName($parameter));
        } catch (BindingResolutionException $e) {

        }
    }

    /**
     * 解析容器中一个可变依赖的类
     *
     * @param ReflectionParameter $parameter
     */
    protected function resolveVariadicClass(ReflectionParameter $parameter)
    {
        $className = Util::getParameterClassName($parameter);

        $abstract = $this->getAlias($className);

        if (! is_array($concrete = $this->getContextualConcrete($abstract))) {
            $this->make($className);
        }

        return array_map(function ($abstract){
            return $this->resolve($abstract);
        }, $concrete);
    }

    public function getAlias($abstract)
    {
        return isset($this->aliases[$abstract])
                    ? $this->getAlias($this->aliases[$abstract])
                    : $abstract;
    }

    protected function resolve(string $abstract, array $parameters = [], $raiseEvents = true)
    {
        $abstract = $this->getAlias($abstract);

        $concrete = $this->getContextualConcrete($abstract);

        $needsContextualBuild = ! empty($parameters) || is_null($concrete);

        if (isset($this->instances[$abstract]) && ! $needsContextualBuild) {
            return $this->instances[$abstract];
        }
    }
}
