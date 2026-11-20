<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Laragon serves this app at http://localhost/jkeiitinv/ while the front
// controller lives in public/. Tell Symfony the base path is /jkeiitinv
// so the "/" route matches. http://jkeiitinv.test/ and /jkeiitinv/public/
// already have a matching script path and are left unchanged.
$subdirectory = '/jkeiitinv';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if (
    str_starts_with($requestPath, $subdirectory)
    && !str_starts_with($requestPath, $subdirectory.'/public')
) {
    $_SERVER['SCRIPT_NAME'] = $subdirectory.'/index.php';
    $_SERVER['PHP_SELF'] = $subdirectory.'/index.php';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
