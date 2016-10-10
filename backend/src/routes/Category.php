<?php

require_once __DIR__ . "/../models/Category.php";

/**
* @SWG\Get(
*     path="/categories",
*     summary="Get All",
*     description="Get all Categories",
*     tags={"Category"},
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

// ^ fix aboces Succces $ref
$app->get('/categories', function ($request, $response, $args) {
    $categories = Category::getAll();
    $output = new Response($categories);
    return $response->getBody()->write(json_encode($output));
});

