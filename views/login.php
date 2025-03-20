<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<header>

</header>
<body>
<form action="login.php" method="POST">
    <h1>Connexion</h1>
    <div class="champ">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" placeholder="Nom">
    </div>
    <div class="champ">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe">
    </div>
    <input class="bouton" type="submit" value="Connexion">
</form>
</body>
<footer>

</footer>

</html>

<?php
require_once '../models/Utilisateur.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation des variables
$modelUtilisateur = new Utilisateur();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        if ($modelUtilisateur->getUtilisateur($username, $password)) {
            session_start();
            $_SESSION['Connecte'] = true;
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            echo '<script type="text/javascript">
            window.onload = function () { alert("Identifiant ou mot de passe incorrect. Veuillez réessayer"); }
            </script>';
        }
    }
}
?>
