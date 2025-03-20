<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
$modelMatch = new MatchHockey();
$matchsAVenir = $modelMatch->getMatchsAVenir();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Match - Menu</title>
    <link rel="stylesheet" href="css/pageGestion.css">
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
    <section id="matchs-a-venir">
        <h2>Matchs à venir</h2>
        <table class="tableau">
            <thead>
            <tr>
                <th>Date</th>
                <th>Adversaire</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($matchsAVenir as $match): ?>
                <tr>
                    <td><?php echo htmlspecialchars($match['dateHeure']); ?></td>
                    <td><?php echo htmlspecialchars($match['nomAdversaire']); ?></td>
                    <td><?php echo htmlspecialchars($match['lieu']); ?></td>
                    <td>
                        <button onclick="location.href='feuilleDeMatch.php?match_id=<?php echo $match['id']; ?>'">Créer/Modifier Feuille de Match</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<footer class="footer">
    <p>© 2024 Coach Hocki Assistant</p>
</footer>
</body>
</html>