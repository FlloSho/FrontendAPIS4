<?php
session_start();
if (!isset($_SESSION['Connecte']) || $_SESSION['Connecte'] == false) {
    header('Location: login.php');
    exit;
}

require_once '../models/Joueur.php';
$modelJoueur = new Joueur();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mettre à jour les informations du joueur
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['dateNaissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $numeroLicence = $_POST['numeroLicence'];
    $statut = $_POST['statut'];

    $modelJoueur->modifierJoueur($id, $nom, $prenom, $dateNaissance, $taille, $poids, $numeroLicence, $statut);
    header('Location: gestionJoueurs.php');
    exit;
} else {
    // Récupérer les informations du joueur
    $id = $_GET['id'];
    $joueur = $modelJoueur->getJoueurParId($id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un joueur - Coach Assistant</title>
    <link rel="stylesheet" href="css/modifierJoueur.css">
</head>
<body>
    <header class="header">
        <h1 class="header-title">Bienvenue, Coach !</h1>
        <nav class="header-nav">
            <a href="gestionJoueurs.php">Gestion des joueurs</a>
            <a href="matchs.html">Gestion des matchs</a>
            <a href="index.php">Statistiques</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main class="main">
        <h2>Modifier les informations du joueur</h2>
        <form action="modifierJoueur.php" method="post" class="form-modifier-joueur">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($joueur['id']); ?>">

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($joueur['nom']); ?>" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($joueur['prenom']); ?>" required>

            <label for="dateNaissance">Date de naissance :</label>
            <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($joueur['dateNaissance']); ?>" required>

            <label for="taille">Taille :</label>
            <input type="number" id="taille" name="taille" value="<?php echo htmlspecialchars($joueur['taille']); ?>" required>

            <label for="poids">Poids :</label>
            <input type="number" id="poids" name="poids" value="<?php echo htmlspecialchars($joueur['poids']); ?>" required>

            <label for="numeroLicence">Numéro de licence :</label>
            <input type="text" id="numeroLicence" name="numeroLicence" value="<?php echo htmlspecialchars($joueur['numeroLicence']); ?>" required>

            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="Actif" <?php if ($joueur['statut'] == 'Actif') echo 'selected'; ?>>Actif</option>
                <option value="Blessé" <?php if ($joueur['statut'] == 'Blessé') echo 'selected'; ?>>Blessé</option>
                <option value="Suspendu" <?php if ($joueur['statut'] == 'Suspendu') echo 'selected'; ?>>Suspendu</option>
                <option value="Absent" <?php if ($joueur['statut'] == 'Absent') echo 'selected'; ?>>Absent</option>
            </select>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </main>
</body>
