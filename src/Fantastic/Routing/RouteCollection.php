<?php

namespace Fantastic\Routing;

use Traversable;

class RouteCollection extends AbstractRouteCollection
{
    /**
     * @var Route[]
     */
    protected $allRoutes = [];

    public function getRoutes()
    {
        return array_values($this->allRoutes);
    }

}
