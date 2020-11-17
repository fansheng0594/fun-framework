<?php

namespace Fantastic\Container;

use ReflectionNamedType;

class Util
{
    /**
     * 如果可以的话，获取给定参数类型的类名
     *
     * @param \ReflectionParameter $parameter
     * @return string|null
     */
    public static function getParameterClassName(\ReflectionParameter $parameter)
    {
        $type = $parameter->getType();

        // 如果是类的话，得出的 type 就是 ReflectionNamedType
        // isBuiltin 是判断是否是内置类型
        if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
            return;
        }

        // 会获取到类名，也可能是 self 或 parent
        // 才知道原来类型约束，也可以设置成 self 或 parent
        $name = $type->getName();

        // $class 是 ReflectionClass Object
        if (! is_null($class = $parameter->getDeclaringClass())) {
            if ($name === 'self') {
                return $class->getName();
            }

            if ($name === 'parent' && $parent = $class->getParentClass()) {
                return $parent->getName();
            }
        }

        return $name;
    }
}
