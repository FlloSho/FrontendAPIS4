<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter vos nouveaux matchs</title>
    <link rel="stylesheet" href="css/AjoutJoueur.css">
</head>

<body>
<header class="header">
    <h1 class="header-title">Bienvenue, Coach !</h1>
    <nav class="header-nav">
        <a href="index.php">Statistiques</a>
        <a href="gestionJoueurs.php">Gestion des joueurs</a>
        <a href="gestionMatchs.php">Gestion des matchs</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>
<form method="post" action="ajoutMatch.php">
    <label for="nomAdversaire">Nom de l'adversaire</label>
    <input type="text" id="nom" name="nomAdversaire" placeholder="Les lynxs de Bagnouls" required>
    <label for="lieu">Lieu de la rencontre</label>
    <input type="text" id="lieu" name="lieu" placeholder="Bagnouls" required>
    <label for="dateHeure">Date et heure de la rencontre</label>
    <input type="datetime-local" id="dateHeure" name="dateHeure" required>
    <button type="submit">Ajouter</button>
</form>

</body>
<footer>
    <p>© 2024 Coach Hocki Assistant</p>
</footer>

</html>

<?php
require_once '../models/MatchHockey.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modelMatch = new MatchHockey();
    if (isset($_POST['nomAdversaire']) && isset($_POST['lieu']) && isset($_POST['dateHeure'])) {
        $nomAdversaire = htmlspecialchars($_POST['nomAdversaire']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $dateHeure = htmlspecialchars($_POST['dateHeure']);

        // affiche les infos pour debugguer
        echo "<pre>";
        var_dump($nomAdversaire);
        var_dump($lieu);
        var_dump($dateHeure);
        echo "</pre>";

        if ($modelMatch->ajouterMatchHockey($nomAdversaire, $lieu, $dateHeure)) {
            echo '<script type="text/javascript">
            window.onload = function () { alert("Le match a bien été ajouté !"); window.location.href = "index.php"; } 
            </script>';
        } else {
            echo "<pre>Erreur lors de l'ajout du match</pre>";
//            echo '<script type="text/javascript">
//            window.onload = function () { alert("Erreur lors de l\'ajout du match"); window.location.href = "index.php"; }
//            </script>';
        }
    }
}
?>