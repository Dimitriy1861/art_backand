<?php
require __DIR__ . "/index.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

function verifyRefreshToken($refreshToken) {
    $refreshSecretKey = $_ENV["JWT_REFRESH_SECRET_KEY"];
    try {
        $decoded = JWT::decode($refreshToken, new Key($refreshSecretKey, 'HS256'));
        if ($decoded->exp < time()) {
            return ['status'=>'error', 'message'=>'Refresh token expired'];
        }
        return ['status'=>'success', 'token'=>$decoded->data];
    } catch (Exception $e) {
        return ['status'=>"error","message"=>'Invalid refresh token'];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input'); // Читаем тело запроса
    $data = json_decode($json, true); // Декодируем JSON в массив
    $refresh_token = $data['token'];
print_r(verifyRefreshToken($refresh_token));
} else {
    echo 'request method not received';
}