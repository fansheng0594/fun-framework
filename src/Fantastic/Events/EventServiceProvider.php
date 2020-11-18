<?php

namespace Fantastic\Events;

use Fantastic\Support\ServiceProvider;
use Fantastic\Contracts\Queue\Factory as QueueFactoryContract;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('events', function ($app){
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });
    }
}
