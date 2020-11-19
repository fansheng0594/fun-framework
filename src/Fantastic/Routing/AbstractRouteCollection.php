<?php

namespace Fantastic\Routing;

use Countable;
use IteratorAggregate;

abstract class AbstractRouteCollection implements Countable, IteratorAggregate, RouteCollectionInterface
{
    public function count()
    {
        return count($this->getRoutes());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getRoutes());
    }
}
