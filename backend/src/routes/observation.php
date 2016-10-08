<?php

$app->get('/observations', function ($request, $response, $args) {
    $name = $args['name'];
    $out = new Response($name);
    return $response->getBody()->write(json_encode($out));
});

$app->get('/observation/{id}', function ($request, $response, $args) {
    $name = $args['name'];
    $out = new Response($name);
    return $response->getBody()->write(json_encode($out));
});

$app->post('/observation', function ($request, $response, $args) {
    $name = $args['name'];
    $out = new Response($name);
    return $response->getBody()->write(json_encode($out));
});