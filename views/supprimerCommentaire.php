<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once  '../models/Commentaire.php';
$modelCommentaire = new Commentaire();

if (isset($_GET['id'])) {
    $idCommentaire = $_GET['id'];
    $idJoueur = $_GET['idJoueur'];
    $modelCommentaire->supprimerCommentaire($idCommentaire);
    header("Location: commentaire.php?id=$idJoueur");
    exit;
}

header('Location: commentaire.php');