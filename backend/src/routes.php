<?php
// Routes

//the root route which redirects to Swagger Docs
//DO NOT MODIFY OR SWAGGER COMMENT THIS ROUTE
$app->get('/', function ($request, $response, $args) {
    //redirect to Swagger Docs
    return $response->withStatus(302)->withHeader("Location", "http://localhost:8888/backend/docs/index.html");
});

require __DIR__ . "/routes/Observation.php";
require __DIR__ . "/routes/Category.php";
