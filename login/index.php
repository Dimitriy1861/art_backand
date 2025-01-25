<?php
require_once __DIR__ . '/loginin.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $email = $_POST["email"];
   echo json_encode(loginIn($email, $password));
}
