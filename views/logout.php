<?php
require_once '../models/Utilisateur.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$modelUtilisateur = new Utilisateur();

// Déconnexion
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}
session_destroy();
header('Location: login.php');
?>

