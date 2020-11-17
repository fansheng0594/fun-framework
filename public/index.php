<?php

include __DIR__.'/../bootstrap/app.php';
class dd
{

}

class bac extends dd
{
    public function __construct(...$d)
    {

    }
}


$reflection = new ReflectionClass('bac');

$constructor = $reflection->getConstructor();
$dependencies = $constructor->getParameters();

foreach ($dependencies as $dependency) {
    $type = $dependency->getType();
    if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
        var_dump(11);
    } else {
        var_dump(22);
    }
    var_dump($dependency->getType());
    var_dump($dependency->isVariadic());die;
    $type = $dependency->getType();
    $class = $dependency->getDeclaringClass();
    var_dump($type);
    var_dump($class);
}
