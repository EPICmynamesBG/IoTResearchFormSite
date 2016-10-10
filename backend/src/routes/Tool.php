<?php

require_once __DIR__ . "/../models/Tool.php";

/**
* @SWG\Get(
*     path="/tools",
*     summary="Get All",
*     description="Get all Tools",
*     tags={"Tool"},
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
$app->get('/tools', function ($request, $response, $args) {
    $tools = Tool::getAll();
    $output = new Response($tools);
    return $response->getBody()->write(json_encode($output));
});

