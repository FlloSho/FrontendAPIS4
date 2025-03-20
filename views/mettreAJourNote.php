<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Participe.php';
$modelParticipe = new Participe();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idJoueur = $_POST['idJoueur'];
    $idMatch = $_POST['idMatch'];
    $note = $_POST['note'];

    $modelParticipe->mettreAJourNoteJoueur($idJoueur, $idMatch, $note);
    header('Location: voirMatchs.php?joueur_id=' . $idJoueur);
    exit;
}

header('Location: gestionJoueurs.php');
exit;
?>