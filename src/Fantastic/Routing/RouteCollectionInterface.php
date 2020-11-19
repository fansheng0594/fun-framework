<?php

namespace Fantastic\Routing;

interface RouteCollectionInterface
{
    /**
     * 获得所有的路由集合
     *
     * @return Route[]
     */
    public function getRoutes();
}
