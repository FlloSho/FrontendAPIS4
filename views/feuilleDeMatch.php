<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/MatchHockey.php';
require_once '../models/Joueur.php';
require_once '../models/Participe.php';

$matchId = $_GET['match_id'];
$modelMatch = new MatchHockey();
$modelJoueur = new Joueur();
$modelParticipe = new Participe();
$match = $modelMatch->getMatchParId($matchId);
$joueurs = $modelJoueur->tousLesJoueurs();
$titulaires = $modelParticipe->getTitulaires($matchId);
$remplacants = $modelParticipe->getRemplacants($matchId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="css/feuilleDeMatch.css">
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
    <h1>Feuille de Match pour <?php echo htmlspecialchars($match['nomAdversaire']); ?></h1>
    <section id="titulaires">
        <h2>Joueurs Titulaires</h2>
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Poste</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($titulaires as $titulaire): ?>
                <tr>
                    <td><?php echo htmlspecialchars($titulaire['nom']); ?></td>
                    <td><?php echo htmlspecialchars($titulaire['prenom']); ?></td>
                    <td>
                        <form action="modifierPoste.php" method="post" id="modifierPoste<?php echo $titulaire['id']; ?>">
                            <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($titulaire['id']); ?>">
                            <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                            <select name="poste" onchange="this.form.submit()">
                                <option value="poste actuel" selected><?php echo $titulaire['poste']; ?></option>
                                <option value="Attaquant">Attaquant</option>
                                <option value="Défenseur">Défenseur</option>
                                <option value="Gardien">Gardien</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($titulaire['statut']); ?></td>
                    <td>
                        <form action="supprimerParticipation.php" method="post" style="display:inline;">
                            <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($titulaire['id']); ?>">
                            <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                            <button class="supprimer" type="submit" >Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <section id="remplacants">
        <h2>Joueurs Remplaçants</h2>
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Poste</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($remplacants as $remplacant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($remplacant['nom']); ?></td>
                    <td><?php echo htmlspecialchars($remplacant['prenom']); ?></td>
                    <td>
                        <form action="modifierPoste.php" method="post" id="modifierPoste<?php echo $remplacant['id']; ?>">
                            <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($remplacant['id']); ?>">
                            <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                            <select name="poste" onchange="this.form.submit()">
                                <option value="poste actuel" selected><?php echo $remplacant['poste']; ?></option>
                                <option value="Attaquant">Attaquant</option>
                                <option value="Défenseur">Défenseur</option>
                                <option value="Gardien">Gardien</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($remplacant['statut']); ?></td>
                    <td>
                        <form action="supprimerParticipation.php" method="post" style="display:inline;">
                            <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($remplacant['id']); ?>">
                            <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                            <button class="supprimer" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <section id="tousLesJoueurs">
        <h2>Tous les Joueurs</h2>
        <div class="tableau-container">
            <table>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($joueur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['statut']); ?></td>
                        <td>
                            <form action="ajouterTitulaireOuRemplacant.php" method="post" style="display:inline;">
                                <input type="hidden" name="choixTitulaireOuRemplacant" value="Titulaire">
                                <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($joueur['id']); ?>">
                                <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                                <input type="hidden" name="poste" value="Pas de poste définit">
                                <button type="submit">Titulaire</button>
                            </form>
                            <form action="ajouterTitulaireOuRemplacant.php" method="post" style="display:inline;">
                                <input type="hidden" name="choixTitulaireOuRemplacant" value="Remplacant">
                                <input type="hidden" name="idJoueur" value="<?php echo htmlspecialchars($joueur['id']); ?>">
                                <input type="hidden" name="idMatch" value="<?php echo htmlspecialchars($matchId); ?>">
                                <input type="hidden" name="poste" value="Pas de poste définit">
                                <button type="submit">Remplaçant</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<footer class="footer">
    <p>© 2024 Coach Hocki Assistant</p>
</footer>
</body>
</html>