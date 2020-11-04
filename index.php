<?php

require __DIR__.'/vendor/autoload.php';

$app = new Fantastic\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? __DIR__
);
