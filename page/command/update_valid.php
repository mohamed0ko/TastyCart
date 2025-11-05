<?php
require_once '../auth/authCheck.php';

if (!isAdmin()) {
    header('Location: /TastyCart/page/403.php');
    exit;
}
?>
<?php

require_once '../../connectData.php';
$id = $_GET['id'];
$success = $_GET['success'];

$sql = $pdo->prepare('update command set valid = ? where id =?');
$sql->execute([$success, $id]);
header('location:listCommand.php?id' . $id);
