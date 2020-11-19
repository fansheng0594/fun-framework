<?php

namespace Fantastic\Routing;

use Fantastic\Support\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRouter();
        $this->registerUrlGenerator();
    }

    /**
     * 注册路由实例
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('router', function ($app){
            return new Router($app['events'], $app);
        });
    }

    protected function registerUrlGenerator()
    {
        $this->app->singleton('url', function ($app){
            $routes = $app['router']->getRoutes();

            $app->instance('routes', $routes);

            return new UrlGenerator(
                $routes, $app->rebinding(
                    'request', $this->requestRebinder()
                ), $app['config']['app.asset_url']
            );
        });
    }

    /**
     * 获取 url 生成器请求绑定器
     */
    protected function requestRebinder()
    {
        return function ($app, $request){
            $app['url']->setRequest($request);
        };
    }
}
