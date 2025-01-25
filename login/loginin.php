<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../dataBase/dataBase.php";
require_once __DIR__ . "/../token/generate/index.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$accessSecretKey=$_ENV['JWT_ACCESS_SECRET_KEY'];
$refreshSecretKey=$_ENV['JWT_REFRESH_SECRET_KEY'];


function loginIn($displayName, $password) {
    $host = $_ENV['HOST_BASE']; // Или IP сервера БД
    $dbname = $_ENV['DB_NAME'];
    $nameDB = $_ENV['DB_USER'];
    $passwordForDB = $_ENV['DB_PASS'];
    $database = new DataBase($host, $nameDB, $passwordForDB, $dbname);
    $displayNameBD=$database->getParametr($displayName, 'users');
    $verify= password_verify($password, $displayNameBD["password_hash"]);
    if ($verify){
        $expireTimeForRefresh=60;
        $expireTimeForAccess=604800;
        $data=[
            'displayName'=>$displayName,
            'role'=>$displayNameBD["role"],
            ];
        $refreshToken=createJwt($data, $expireTimeForRefresh, 'refresh');
        $accessToken=createJwt($refreshToken, $expireTimeForAccess, 'access');
        return [
            'accessToken'=>$accessToken,
            'refreshToken'=>$refreshToken,
        ];
    } else {
        return 'login failed';
    }
}
?>
