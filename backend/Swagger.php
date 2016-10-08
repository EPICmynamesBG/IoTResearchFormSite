<?php

require("vendor/autoload.php");
$swagger = \Swagger\scan(['./public', './src']);
header('Content-Type: application/json');
echo $swagger;
