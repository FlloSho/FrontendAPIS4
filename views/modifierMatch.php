<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
$modelMatch = new MatchHockey();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mettre à jour les informations du match
    $id = $_POST['id'];
    $dateHeure = $_POST['dateHeure'];
    $nomAdversaire = $_POST['nomAdversaire'];
    $lieu = $_POST['lieu'];

    $modelMatch->modifierMatchHockey($id, $nomAdversaire, $lieu, $dateHeure);
    header('Location: gestionMatchs.php');
    exit;
} else {
    // Récupérer les informations du match
    $id = $_GET['id'];
    $match = $modelMatch->getMatchParId($id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un match - Coach Assistant</title>
    <link rel="stylesheet" href="css/modifierJoueur.css">
</head>
<body>
<header class="header">
    <h1 class="header-title">Bienvenue, Coach !</h1>
    <nav class="header-nav">
        <a href="gestionJoueurs.php">Gestion des joueurs</a>
        <a href="gestionMatchs.php">Gestion des matchs</a>
        <a href="index.php">Statistiques</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>
<main class="main">
    <h2>Modifier les informations du match</h2>
    <form action="modifierMatch.php" method="post" class="form-modifier-joueur">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($match['id']); ?>">

        <label for="dateHeure">Date et heure :</label>
        <input type="datetime-local" id="dateHeure" name="dateHeure" value="<?php echo htmlspecialchars($match['dateHeure']); ?>" required>

        <label for="nomAdversaire">Nom de l'adversaire :</label>
        <input type="text" id="nomAdversaire" name="nomAdversaire" value="<?php echo htmlspecialchars($match['nomAdversaire']); ?>" required>

        <label for="lieu">Lieu :</label>
        <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($match['lieu']); ?>" required>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</main>
</body>
</html>
