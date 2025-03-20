<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Joueur.php';
$modelJoueur = new Joueur();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $modelJoueur->supprimerJoueur($id);
}

header('Location: gestionJoueurs.php');
exit;
?>
