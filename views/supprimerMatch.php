<?php

session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
$modelMatch = new MatchHockey();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $modelMatch->supprimerMatchHockey($id);
}

header('Location: gestionMatchs.php');
exit;
?>
