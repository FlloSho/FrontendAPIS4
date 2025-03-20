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
    $idCommentaire = $_POST['idCommentaire'];
    $commentaire = $_POST['commentaire'];

    $modelCommentaire->modifierCommentaire($commentaire, $idCommentaire);
    header('Location: commentaire.php?id=' . $idJoueur);

} else {
    if (isset($_GET['id'])) {
        $idCommentaire = $_GET['id'];
        $idJoueur = $_GET['idJoueur'];
    } else {
        echo "ID du commentaire non spécifié.";
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
    <title>Modifier un commentaire</title>
    <link rel="stylesheet" href="css/ajouterCommentaire.css">
</head>
<body>
<header class="header">
    <h1 class="header-title">Modifier le commentaire</h1>
    <nav class="header-nav">
        <a href="gestionJoueurs.php">Gestion des joueurs</a>
        <a href="matchs.html">Gestion des matchs</a>
        <a href="index.php">Statistiques</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>
<main class="main">
    <h2>Modifier le commentaire !</h2>
    <form action="modifierCommentaire.php" method="post" class="form-ajouter-commentaire">
        <input type="hidden" name="idCommentaire" value="<?php echo htmlspecialchars($idCommentaire); ?>">
        <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($idJoueur); ?>">

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire" required><?php echo $modelCommentaire->afficherUnCommentaire($idCommentaire)['commentaire'] ?></textarea>

        <button type="submit">Sauvegarder</button>
    </form>
</main>
</body>
</html>
