<?php
require_once __DIR__ . '/loginin.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $displayName = $_POST["displayName"];
   echo json_encode(loginIn($displayName, $password));
}
