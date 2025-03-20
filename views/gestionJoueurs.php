<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Joueur.php';
$modelJoueur = new Joueur();
$joueurs = $modelJoueur->tousLesJoueurs();
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
        <h2>Liste des joueurs</h2>
        <div class="tableau-container">
            <table class="tableau">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Numéro de licence</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($joueur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['dateNaissance']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['taille']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['poids']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['numeroLicence']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['statut']); ?></td>
                        <td>
                            <button onclick="location.href='voirMatchs.php?joueur_id=<?php echo $joueur['id']; ?>'">Voir les matchs</button>

                            <form id="supprimerForm<?php echo $joueur['id']; ?>" action="supprimerJoueur.php" method="get" style="display: none;">
                                <input type="hidden" name="id" value="<?php echo $joueur['id']; ?>">
                            </form>
                            <button class="supprimer" onclick="confirmSuppression(<?php echo $joueur['id']; ?>)">Supprimer</button>
                            <script>
                                function confirmSuppression(id) {
                                    if (confirm("Êtes-vous sûr de vouloir supprimer ce joueur ?")) {
                                        document.getElementById('supprimerForm' + id).submit();
                                    }
                                }
                            </script>

                            <button onclick="location.href='modifierJoueur.php?id=<?php echo $joueur['id']; ?>'">Modifier</button>

                            <button onclick="location.href='commentaire.php?id=<?php echo $joueur['id']; ?>'">Voir commentaire</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button class="horsTab" onclick="location.href='ajoutJoueur.php'">Ajouter un joueur</button>

        <!-- Section des statistiques générales -->
        <section id="statistiques-generales">
            <h2>Statistiques générales</h2>
            <p>Nombre total de joueurs : <?php echo count($joueurs); ?></p>
            <p>Nombre de joueurs actifs : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Actif'; })); ?></p>
            <p>Nombre de joueurs blessés : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Blessé'; })); ?></p>
            <p>Nombre de joueurs suspendus : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Suspendu'; })); ?></p>
            <p>Nombre de joueurs absents : <?php echo count(array_filter($joueurs, function($joueur) { return $joueur['statut'] == 'Absent'; })); ?></p>
        </section>
    </main>
</body>
</html>
