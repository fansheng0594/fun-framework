<?php

namespace Fantastic\Support;

abstract class ServiceProvider
{
    protected $app;
    protected $bootingCallbacks = [];
    protected $bootedCallbacks = [];

    /**
     * ServiceProvider constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 调用已注册的初始回调
     *
     * @return void
     */
    public function callBootingCallbacks()
    {
        foreach ($this->bootingCallbacks as $callback) {
            $this->app->call($callback);
        }
    }

    public function callBootedCallbacks()
    {
        foreach ($this->bootedCallbacks as $callback) {
            $this->app->call($callback);
        }
    }
}
