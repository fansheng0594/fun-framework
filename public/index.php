<?php

include __DIR__.'/../bootstrap/app.php';

class DC implements IteratorAggregate
{
    public $name = 'Jane';

    public $age = 23;

    public $weight = 55;

    protected $array = [
        'name' => 'Judy',
        'age' => 29,
        'language' => 'English'
    ];

    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }
}

$o = new DC();
foreach ($o as $key => $val) {
    var_dump($key . '|||' . $val . '<br>');
}
