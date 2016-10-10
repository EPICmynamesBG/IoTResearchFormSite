<?php

require_once __DIR__ . "/../models/User.php";

/**
* @SWG\Get(
*     path="/users",
*     summary="Get All",
*     description="Get all Users",
*     tags={"User"},
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
$app->get('/users', function ($request, $response, $args) {
    $users = User::getAll();
    $output = new Response($users);
    return $response->getBody()->write(json_encode($output));
});

