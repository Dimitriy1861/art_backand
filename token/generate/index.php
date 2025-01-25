<?php
require __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../dataBase/dataBase.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
use Firebase\JWT\JWT;


function createJwt($data, $expireTime, $type) {
    $refreshSecretKey = $_ENV["JWT_REFRESH_SECRET_KEY"];
    $accessSecretKey = $_ENV["JWT_ACCESS_SECRET_KEY"];

 $payload=[
     'data'=>$data,
     'iat'=>time(),
     'exp'=>time() + $expireTime,
 ];
 if ($type==='access') {
     return JWT::encode($payload, $accessSecretKey, 'HS256');
 } else {
     return JWT::encode($payload, $refreshSecretKey, 'HS256');
 }

}



