<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);

require '../models/MatchHockey.php';
$matchHockey = new MatchHockey();
$matchs = $matchHockey->tousLesMatchs();

require '../models/Joueur.php';
$joueur = new Joueur();
$joueurs = $joueur->tousLesJoueurs();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Coach Assistant</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<header class="header">
    <h1 class="header-title">Bienvenue, Coach !</h1>
    <nav class="header-nav">
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Statistiques</a>
        <a href="gestionJoueurs.php" class="<?= ($current_page == 'gestionJoueurs.php') ? 'active' : '' ?>">Gestion des
            joueurs</a>
        <a href="gestionMatchs.php" class="<?= ($current_page == 'gestionMatchs.php') ? 'active' : '' ?>">Gestion des
            matchs</a>
        <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">Déconnexion</a>
    </nav>
</header>

<main class="main">
    <section id="statistiques-resume">
        <h2>Statistiques générales</h2>
        <div class="stats">
            <div class="stats-matchs">
                <p>Matchs en attente : <span id="matchs-attente">
                    <?php
                    $matchsEnAttente = 0;
                    $matchJoués = 0;
                    $victoires = 0;
                    $defaites = 0;
                    $nuls = 0;
                    foreach ($matchs as $match) {
                        if ($match['resultat'] !== 'En attente') {
                            $matchJoués++;
                        } else {
                            $matchsEnAttente++;
                        }
                        if ($match['resultat'] === 'Victoire') {
                            $victoires++;
                        } elseif ($match['resultat'] === 'Défaite') {
                            $defaites++;
                        } elseif ($match['resultat'] === 'Match nul') {
                            $nuls++;
                        }
                    }
                    echo $matchsEnAttente;
                    ?>
                <p>Matchs joués : <span id="total-matchs">
                    <?php
                    echo $matchJoués;
                    ?>
                </span></p>
                <p>Victoires : <span id="pourcentage-victoires">
                    <?php
                    if ($matchJoués === 0) {
                        echo 0;
                    } else {
                        echo $victoires . " (" . round(($victoires / $matchJoués) * 100);
                    }
                    ?>
                    %)
                </span></p>
                <p>Défaites : <span id="pourcentage-defaites">
                    <?php
                    if ($matchJoués === 0) {
                        echo 0;
                    } else {
                        echo $defaites . " (" . round(($defaites / $matchJoués) * 100);
                    }
                    ?>
                    %)
                </span></p>
                <p>Matchs nuls : <span id="pourcentage-nuls">
                    <?php
                    if ($matchJoués === 0) {
                        echo 0;
                    } else {
                        echo $nuls . " (" . round(($nuls / $matchJoués) * 100);
                    }
                    ?>
                    %)
                </span></p>
            </div>
            <div class="stats-joueurs">
                <p>Nombre total de joueurs : <?php echo count($joueurs); ?></p>
                <p>Joueurs actifs : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Actif'; })); ?></p>
                <p>Joueurs blessés : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Blessé'; })); ?></p>
                <p>Joueurs suspendus : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Suspendu'; })); ?></p>
                <p>Joueurs absents : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Absent'; })); ?></p>
            </div>
        </div>

    </section>

    <section id="matchs-a-venir">
        <h2>Prochains matchs</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Date et heure</th>
                <th>Adversaire</th>
                <th>Lieu</th>
            </tr>
            </thead>
            <tbody>
            <!-- Les données seront insérées dynamiquement -->
            <?php
            foreach ($matchs as $match) {
                if ($match['resultat'] === 'En attente') {
                    echo '<tr>';
                    echo '<td>' . date('d/m/Y H:i', strtotime($match['dateHeure'])) . '</td>';
                    echo '<td>' . $match['nomAdversaire'] . '</td>';
                    echo '<td>' . $match['lieu'] . '</td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </section>

    <section id="actions-rapides">
        <h2>Actions rapides</h2>
        <button onclick="location.href='ajoutJoueur.php'">Ajouter un joueur</button>
        <button onclick="location.href='ajoutMatch.php'">Ajouter un match</button>
        <button onclick="location.href='feuilleDeMatchMenu.php'">Préparer une feuille de match</button>
    </section>
</main>

</body>
</html>
