<?php
session_start();

if (!isset($_SESSION['users'])) {
    http_response_code(403);
    echo "please login";
    exit;
}
$userId = $_SESSION['users']['id'];
$id = (int)$_POST['id'];
unset($_SESSION['cart'][$userId][$id]);


header("location:" . $_SERVER['HTTP_REFERER']);
