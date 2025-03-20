<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter vos nouveaux joueurs</title>
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

<form method="post" action="ajoutJoueur.php">
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" placeholder="LeBon" required>
    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" placeholder="Jean" required>
    <label for="dateNaissance">Années de naissance</label>
    <input type="date" id="numero" name="dateNaissance" required>
    <label for="taille">Taille</label>
    <input type="number" id="taille" name="taille" placeholder="En cm (176)" required>
    <label for="poids">Poids</label>
    <input type="number" id="poids" name="poids" placeholder="En kilos (84)" required>
    <label for="numero">Numéro de licence</label>
    <input type="number" id="numero" name="numero" placeholder="57785454" required>
    <button type="submit">Ajouter</button>
</form>

</body>
<footer>
    <p>© 2024 Coach Hocki Assistant</p>
</footer>
</html>

<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../models/Joueur.php';
    $modelJoueur = new Joueur();
    $nom = null;
    $prenom = null;
    $dateNaissance = null;
    $taille = null;
    $poids = null;
    $numero = null;
    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateNaissance']) && isset($_POST['taille']) && isset($_POST['poids']) && isset($_POST['numero'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
        $taille = htmlspecialchars($_POST['taille']);
        $poids = htmlspecialchars($_POST['poids']);
        $numero = htmlspecialchars($_POST['numero']);
    }
    if($modelJoueur->ajouterJoueur($nom, $prenom, $dateNaissance, $taille, $poids, $numero)){
        echo '<script type="text/javascript">
       window.onload = function () { alert("Le joueur a bien été ajouté !"); } 
        </script>';
    }else{
        echo '<script type="text/javascript">
   window.onload = function () { alert("Erreur lors de l\'ajout du joueur"); } 
    </script>';
    }

}
exit;
?>

