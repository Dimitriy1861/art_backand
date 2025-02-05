<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../dataBase/dataBase.php";
require_once __DIR__ . "/../token/generate/index.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$accessSecretKey=$_ENV['JWT_ACCESS_SECRET_KEY'];
$refreshSecretKey=$_ENV['JWT_REFRESH_SECRET_KEY'];


function loginIn($email, $password) {
    $host = $_ENV['HOST_BASE']; // Или IP сервера БД
    $dbname = $_ENV['DB_NAME'];
    $nameDB = $_ENV['DB_USER'];
    $passwordForDB = $_ENV['DB_PASS'];
    $database = new DataBase($host, $nameDB, $passwordForDB, $dbname);
    $emailBD=$database->getParametr($email, 'users');
    if ($emailBD&&$emailBD["password_hash"]) {
        $verify= password_verify($password, $emailBD["password_hash"]);
        if ($verify){
            $expireTimeForRefresh=60;
            $expireTimeForAccess=604800;
            $data=[
                'email'=>$email,
                'role'=>$emailBD["role"],
                ];
            $refreshToken=createJwt($data, $expireTimeForRefresh, 'refresh');
            $accessToken=createJwt($data, $expireTimeForAccess, 'access');
            return [
                'status'=>'success',
                'accessToken'=>$accessToken,
                'refreshToken'=>$refreshToken,
                'role'=>$data['role'],
            ];
        } else {
            return [
            'status'=> 'error',
            'message'=> 'Проверьте электронную почту и пароль',
            ];
        }
    } else {
      return [
               'status'=> 'error',
               'message'=> 'login failed ok',
               ];
    }

}
?>
