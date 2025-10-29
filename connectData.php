<?php
$cont = 'mysql:host =127.0.0.1;dbname=TastyCart;charset=utf8';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO($cont, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'database connected ';
} catch (PDOException $r) {
    echo "error:" . $r->getMessage();
}
