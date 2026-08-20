<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// [WASM FIX] PHPix/Wasmer environments often omit 'E' in php.ini 'variables_order', leaving $_ENV empty.
// Laravel's env() helper heavily relies on $_ENV, so we explicitly merge $_SERVER (which PHPix populates) into $_ENV.
if (empty($_ENV) || !isset($_ENV['DB_DATABASE'])) {
    $_ENV = array_merge($_SERVER, $_ENV);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
