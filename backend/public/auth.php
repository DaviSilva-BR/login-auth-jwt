<?php

include_once('../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-srf-token, x_csrftoken, Cache-Control, X-Requested-With");

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();


$authorizantion = $_SERVER["HTTP_AUTHORIZATION"];

$token  = str_replace('Bearer ', '', $authorizantion);

try {
    $decoded = JWT::decode($token, new Key($_SERVER['KEY'], 'HS256'));

    echo json_encode($decoded);
} catch (\Throwable $e) {
    if ($e->getMessage() === "Expired token") {
        http_response_code(401);
        die($e->getMessage());
    }
    echo json_encode($e->getMessage());
}
