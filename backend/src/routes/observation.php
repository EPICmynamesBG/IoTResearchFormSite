<?php

require_once __DIR__ . "/../models/Observation.php";

/**
* @SWG\Get(
*     path="/observations",
*     summary="Get All",
*     description="Get all Observations",
*     tags={"Observation"},
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

$app->get('/observations', function ($request, $response, $args) {
    $observations = Observation::getAll();
    $output = new Response($observations);
    return $response->getBody()->write(json_encode($output));
});

/**
* @SWG\Get(
*     path="/books/{id}",
*     summary="Get by Id",
*     description="Get an Observation by Id",
*     tags={"Observation"},
*     @SWG\Parameter(
*         name="Id",
*         in="path",
*         description="an Observation Id",
* 		  required=true,
*		  type=int,
*         default="2"
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleObservationSuccess"
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
$app->get('/observation/{id}', function ($request, $response, $args) {
    if (!isset($args['id'])){
        throw new Exception("Missing parameter: Id", 400);
    }
    $obs = Observation::getById($args['id']);
    $out = new Response($obs);
    return $response->getBody()->write(json_encode($out));
});

/**
* @SWG\Post(
*     path="/observation",
*     summary="Create",
*     description="Create an Observation",
*     tags={"Observation"},
*     @SWG\Parameter(
*        name="body",
*        in="body",
*        description="Observation JSON Body",
*        required=true,
*        @SWG\Schema(ref="#/definitions/PostBody")
*     ),
*     @SWG\Response(
*         response=200,
*         description="Success",
*         @SWG\Schema(
*             ref="#/definitions/SingleObservationSuccess"
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

$app->post('/observation', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    
    $observation = Observation::create($body);
    $output = new Response($observation);
    
    return $response->getBody()->write(json_encode($output));
});
