<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Commentaire.php';
$modelCommentaire = new Commentaire();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idJoueur = $_POST['idJoueur'];
    $commentaire = $_POST['commentaire'];

    $modelCommentaire->ajouterCommentaire($commentaire, $idJoueur);
    header('Location: commentaire.php?id=' . $idJoueur);

} else {
    if (isset($_GET['id'])) {
        $idJoueur = $_GET['id'];
    } else {
        echo "ID du joueur non spécifié.";
        header('Location: gestionJoueurs.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="css/ajouterCommentaire.css">
</head>
<body>
<header class="header">
    <h1 class="header-title">Ajouter un commentaire</h1>
    <nav class="header-nav">
        <a href="gestionJoueurs.php">Gestion des joueurs</a>
        <a href="matchs.html">Gestion des matchs</a>
        <a href="index.php">Statistiques</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>
<main class="main">
    <h2>Nouveau commentaire</h2>
    <form action="ajouterCommentaire.php" method="post" class="form-ajouter-commentaire">
        <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($idJoueur); ?>">

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire" required></textarea>

        <button type="submit">Ajouter le commentaire</button>
    </form>
</main>
</body>
</html>
