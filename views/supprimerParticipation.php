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

    $modelParticipe->retirerParticipation($idJoueur, $idMatch);
    print_r($_POST);
    header('Location: feuilleDeMatch.php?match_id=' . $idMatch);
    exit;
}

header('Location: feuilleDeMatch.php?match_id=' . $_POST['idMatch']);
exit;
?>
