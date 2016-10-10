<?php

/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="localhost:8888",
 *   basePath="/backend/public",
 *   consumes={"application/json"},
 *   produces={"application/json"},
 *   @SWG\Info(
 *     title="IoT Research Form",
 *     description="A reseach data collection form",
 *     version="1.0.0",
 *     @SWG\Contact(name="Brandon Groff", email="mynamesbg@gmail.com"),
 * 	   @SWG\License(name="MIT", url="https://opensource.org/licenses/MIT")
 *   )
 * )
 *
 */

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/config/db.php';
require __DIR__ . '/../src/util/response.php';

$app->add(function($request, $response, $next) {
    $response = $response->withHeader('Content-Type', 'application/json');
//    $response = $response->withHeader('Access-Control-Allow-Origin', 'http://bgroff-pi2.dhcp.bsu.edu');
//    $response = $response->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
//    $response = $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    return $next($request, $response);
});

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();