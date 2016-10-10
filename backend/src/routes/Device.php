<?php

require_once __DIR__ . "/../models/Device.php";

/**
* @SWG\Get(
*     path="/devices",
*     summary="Get All",
*     description="Get all Devices",
*     tags={"Device"},
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/ArrayObservationSuccess"
*         )
*     ),
*     @SWG\Response(
*         response="default",
*         description="Error",
*         @SWG\Schema(
*             ref="#/definitions/Error"
*         )
*     )
* )
*/

// ^ fix above Succces $ref
$app->get('/devices', function ($request, $response, $args) {
    $devices = Device::getAll();
    $output = new Response($devices);
    return $response->getBody()->write(json_encode($output));
});

