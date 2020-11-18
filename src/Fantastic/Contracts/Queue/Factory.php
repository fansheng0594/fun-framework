<?php

namespace Fantastic\Contracts\Queue;

interface Factory
{
    /**
     * 解析队列连接实例
     *
     * @param string|null $name
     */
    public function connection($name = null);
}
