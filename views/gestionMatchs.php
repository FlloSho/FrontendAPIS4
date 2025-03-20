<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
$modelMatch = new MatchHockey();
$matchs = $modelMatch->tousLesMatchs();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des joueurs - Coach Assistant</title>
    <link rel="stylesheet" href="css/pageGestion.css">
</head>
<body>
<header class="header">
    <h1 class="header-title">Bienvenue, Coach !</h1>
    <nav class="header-nav">
        <a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Statistiques</a>
        <a href="gestionJoueurs.php" class="<?= ($current_page == 'gestionJoueurs.php') ? 'active' : '' ?>">Gestion des joueurs</a>
        <a href="gestionMatchs.php" class="<?= ($current_page == 'gestionMatchs.php') ? 'active' : '' ?>">Gestion des matchs</a>
        <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">Déconnexion</a>
    </nav>
</header>
<main class="main">
    <h2>Liste des matchs</h2>
    <div class="tableau-container">
        <table class="tableau">
            <thead>
            <tr>
                <th>Date et heure</th>
                <th>Adversaire</th>
                <th>Lieu de la rencontre</th>
                <th>Résultat</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($matchs as $match): ?>
                <tr>
                    <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($match['dateHeure']))); ?></td>
                    <td><?php echo htmlspecialchars($match['nomAdversaire']); ?></td>
                    <td><?php echo htmlspecialchars($match['lieu']); ?></td>
                    <td><?php echo htmlspecialchars($match['resultat']); ?></td>
                    <td>
                        <form id="supprimerForm<?php echo $match['id']; ?>" action="supprimerMatch.php" method="get"
                              style="display: none;">
                            <input type="hidden" name="id" value="<?php echo $match['id']; ?>">
                        </form>
                        <button class="supprimer" onclick="confirmSuppression(<?php echo $match['id']; ?>)">Supprimer
                        </button>
                        <script>
                            function confirmSuppression(id) {
                                if (confirm("Êtes-vous sûr de vouloir supprimer ce match ?")) {
                                    document.getElementById('supprimerForm' + id).submit();
                                }
                            }
                        </script>

                        <button onclick="location.href='modifierMatch.php?id=<?php echo $match['id']; ?>'">Modifier
                        </button>

                        <?php if ($match['resultat'] == 'En attente'): ?>
                            <button onclick="location.href='ajoutResultatMatch.php?id=<?php echo $match['id']; ?>'">
                                Ajouter un résultat
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button class="horsTab" onclick="location.href='ajoutMatch.php'">Ajouter un match</button>
    <button class="horsTab" onclick="location.href='feuilleDeMatchMenu.php'">Feuille de match</button>

    <!-- Section des statistiques générales -->
    <section id="statistiques-generales">
        <h2>Statistiques générales</h2>
        <p>Nombre total de matchs : <?php echo count($matchs); ?></p>
        <p>Matchs en attente :
            <?php
            $matchsEnAttente = count(array_filter($matchs, function ($match) {
                return $match['resultat'] == 'En attente';
            }));
            echo $matchsEnAttente;
            ?>
        </p>
        <p>Matchs joués :
            <?php
            $matchsJoues = count(array_filter($matchs, function ($match) {
                return $match['resultat'] !== 'En attente';
            }));
            echo $matchsJoues;
            ?>
        <p>Nombre de matchs gagnés :
            <?php
            $totalMatchs = count($matchs);
            $victoires = count(array_filter($matchs, function ($match) {
                return $match['resultat'] == 'Victoire';
            }));
            echo $victoires;
            if ($totalMatchs > 0) {
                echo " soit " . round(($victoires / $matchsJoues) * 100) . "%";
            } else {
                echo " soit 0%";
            }
            ?>
        </p>
        <p>Nombre de matchs perdus :
            <?php
            $defaites = count(array_filter($matchs, function ($match) {
                return $match['resultat'] == 'Défaite';
            }));
            echo $defaites;
            if ($totalMatchs > 0) {
                echo " soit " . round(($defaites / $matchsJoues) * 100) . "%";
            }
            ?>
        </p>
        <p>Nombre de matchs nuls :
            <?php
            $nuls = count(array_filter($matchs, function ($match) {
                return $match['resultat'] == 'Match nul';
            }));
            echo $nuls;
            if ($totalMatchs > 0) {
                echo " soit " . round(($nuls / $matchsJoues) * 100) . "%";
            }
            ?>
        </p>
    </section>
</main>
</body>
</html>
