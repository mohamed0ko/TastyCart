<?php
session_start();

if (!isset($_SESSION['users'])) {
    http_response_code(403);
    echo "please login";
    exit;
}

$id = (int)$_POST['id'];
$qte = (int)$_POST['qte'];
$userId = $_SESSION['users']['id'];


if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (!isset($_SESSION['cart'][$userId]) || !is_array($_SESSION['cart'][$userId])) {
    $_SESSION['cart'][$userId] = [];
}

if ($qte === 0) {
    unset($_SESSION['cart'][$userId][$id]);
} else {
    $_SESSION['cart'][$userId][$id] = $qte;
}

header("location:detailProduct.php?id=$id");
