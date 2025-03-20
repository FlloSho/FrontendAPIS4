<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Commentaire.php';
$modelCommentaire = new Commentaire();

if (isset($_GET['id'])) {
    $idJoueur = $_GET['id'];
    $commentaires = $modelCommentaire->afficherCommentaire($idJoueur);
} else {
    echo "ID du joueur non spécifié.";
    header('Location: gestionJoueurs.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire(s)</title>
    <link rel="stylesheet" href="css/commentaire.css">
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
<main class="main">
    <?php if (!empty($commentaires)): ?>
        <h2>Commentaires existants</h2>
        <ul>
            <?php foreach ($commentaires as $commentaire): ?>
                <li>
                    <p><?php echo htmlspecialchars($commentaire['commentaire']); ?></p>
                    <div class="lesBoutons">
                        <button onclick="location.href='modifierCommentaire.php?id=<?php echo $commentaire['id']; ?>&idJoueur=<?php echo $idJoueur; ?>'">Modifier</button>
                        <button class="supprimer" onclick="location.href='supprimerCommentaire.php?id=<?php echo $commentaire['id']; ?>&idJoueur=<?php echo $idJoueur; ?>'">Supprimer</button>
                    </div>
                </li>
            <?php endforeach; ?>

            <button class="hors" onclick="location.href='ajouterCommentaire.php?id=<?php echo $idJoueur; ?>'">Ajouter un commentaire</button>
        </ul>
    <?php else: ?>
        <p>Aucun commentaire trouvé pour ce joueur.</p>
        <button onclick="location.href='ajouterCommentaire.php?id=<?php echo $idJoueur; ?>'">Ajouter un commentaire</button>
    <?php endif; ?>
</main>
</body>
</html>