<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Participe.php';
require_once '../models/MatchHockey.php';

$idJoueur = $_GET['joueur_id'];
$modelParticipe = new Participe();
$modelMatchHockey = new MatchHockey();

$matchs = $modelParticipe->getMatchsParJoueur($idJoueur);
$posteLePlusJoue = $modelParticipe->getPosteLePlusJoue($idJoueur);
$noteMoyenne = $modelParticipe->getNoteMoyenne($idJoueur);
$pourcentageVictoire = $modelParticipe->getPourcentageVictoire($idJoueur);
$pourcentageDefaite = $modelParticipe->getPourcentageDefaite($idJoueur);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matchs du joueur</title>
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
    <h2>Matchs du joueur</h2>
    <table class="tableau">
        <thead>
        <tr>
            <th>Date</th>
            <th>Adversaire</th>
            <th>Lieu</th>
            <th>Résultat</th>
            <th>Poste occupé</th>
            <th>Note</th>
            <th>Commentaire</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($matchs as $match): ?>
            <tr>
                <td><?php echo htmlspecialchars($match['dateHeure']); ?></td>
                <td><?php echo htmlspecialchars($match['nomAdversaire']); ?></td>
                <td><?php echo htmlspecialchars($match['lieu']); ?></td>
                <td><?php echo htmlspecialchars($match['resultat']); ?></td>
                <td><?php echo htmlspecialchars($match['poste']); ?></td>
                <td>
                    <form action="mettreAJourNote.php" method="post">
                        <input type="hidden" name="idJoueur" value="<?php echo $idJoueur; ?>">
                        <input type="hidden" name="idMatch" value="<?php echo $match['id']; ?>">
                        <select name="note" onchange="this.form.submit()">
                            <option value="">Pas de note</option>
                            <?php for ($i = 0; $i <= 20; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($match['note'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </td>
                <td>
                    <button onclick="location.href='commentaire.php?id=<?php echo $idJoueur; ?>'">Ajouter un commentaire</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <section id="statistiques-generales">
        <h3>Statistiques du joueur</h3>
        <p>Poste le plus joué : <?php echo htmlspecialchars($posteLePlusJoue ? $posteLePlusJoue['poste'] : 'Pas de données'); ?></p>
        <p>Note moyenne :
            <?php
            if ($noteMoyenne['moyenne'] > 0) {
                echo htmlspecialchars(number_format(($noteMoyenne['moyenne']), 2));
            } else {
                echo 'Pas de données';
            }
            ?>
        <p>Pourcentage de victoire :
            <?php
            if ($pourcentageVictoire && $pourcentageVictoire['total'] > 0) {
                echo htmlspecialchars(number_format(($pourcentageVictoire['gagne'] / $pourcentageVictoire['total']) * 100, 2)) . '%';
            } else {
                echo 'Pas de données';
            }
            ?>
        </p>
        <p>Pourcentage de défaite :
            <?php
            if ($pourcentageDefaite && $pourcentageDefaite['total'] > 0) {
                echo htmlspecialchars(number_format(($pourcentageDefaite['perdu'] / $pourcentageDefaite['total']) * 100, 2)) . '%';
            } else {
                echo 'Pas de données';
            }
            ?>
        </p>
    </section>
</main>
<footer class="footer">
    <p>© 2024 Coach Hocki Assistant</p>
</footer>
</body>
</html>