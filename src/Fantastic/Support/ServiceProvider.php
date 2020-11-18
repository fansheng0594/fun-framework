<?php

namespace Fantastic\Support;

abstract class ServiceProvider
{
    protected $app;

    /**
     * ServiceProvider constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
}
