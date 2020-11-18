<?php

namespace Fantastic\Events;

use Fantastic\Container\Container;
use Fantastic\Contracts\Container\Container as ContainerContract;
use Fantastic\Contracts\Events\Dispatcher as DispatcherContract;

class Dispatcher implements DispatcherContract
{
    /**
     * @var ContainerContract
     */
    protected $container;
    /**
     * @var callable
     */
    protected $queueResolver;

    /**
     * Dispatcher constructor.
     * @param ContainerContract|null $container
     */
    public function __construct(ContainerContract $container = null)
    {
        $this->container = $container ?: new Container;
    }

    public function listen($events, $listener = null)
    {
        // TODO: Implement listen() method.
    }

    public function hasListeners($eventName)
    {
        // TODO: Implement hasListeners() method.
    }

    public function subscribe($subscriber)
    {
        // TODO: Implement subscribe() method.
    }

    public function until($event, $payload = [])
    {
        // TODO: Implement until() method.
    }

    public function dispatch($event, $payload = [], $halt = false)
    {
        // TODO: Implement dispatch() method.
    }

    public function push($event, $payload = [])
    {
        // TODO: Implement push() method.
    }

    public function flush($event)
    {
        // TODO: Implement flush() method.
    }

    public function forget($event)
    {
        // TODO: Implement forget() method.
    }

    public function forgetPushed()
    {
        // TODO: Implement forgetPushed() method.
    }

    /**
     * @param callable $resolver
     * @return $this
     */
    public function setQueueResolver(callable $resolver)
    {
        $this->queueResolver = $resolver;

        return $this;
    }
}
