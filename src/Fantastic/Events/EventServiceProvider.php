<?php

namespace Fantastic\Event;

use Fantastic\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('events', function ($app){
            return ();
        });
    }
}
