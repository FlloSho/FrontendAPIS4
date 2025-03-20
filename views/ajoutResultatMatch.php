<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
$modelMatch = new MatchHockey();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $resultat = $_POST['resultat'];

    $modelMatch->ajouterResultat($id, $resultat);
    header('Location: gestionMatchs.php');
    exit;
} else {
    $id = $_GET['id'];
    $match = $modelMatch->getMatchParId($id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un résultat - Coach Assistant</title>
    <link rel="stylesheet" href="css/modifierJoueur.css"> <!-- On réutilise le css existant donc certain nom de classe ne seront pas cohérent avec les actions de la page -->
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
        <h2>Ajouter un résultat pour le match contre <?php echo htmlspecialchars($match['nomAdversaire']); ?></h2>
        <form action="ajoutResultatMatch.php" method="post" class="form-modifier-joueur">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($match['id']); ?>">

            <label for="resultat">Résultat :</label>
            <select id="resultat" name="resultat" required>
                <option value="Victoire">Victoire</option>
                <option value="Défaite">Défaite</option>
                <option value="Match nul">Match nul</option>
            </select>

            <button type="submit">Enregistrer le résultat</button>
        </form>
    </main>
</body>
</html>
