<!DOCTYPE HTML>
<meta charset="utf-8">
<html>

<head lang="fr">
    <title>Modification de joueur</title>
    <link rel="stylesheet" href="PageStyle.css" />
</head>

<body>
    <nav>
        <ul>
            <li><a href="PageAccueil.php">Accueil</a></li>
            <li><a href="GestionEquipe.php">Gestion des joueurs</a></li>
            <li><a href="PageGestionMatch.php">Gestion des matchs</a></li>
            <li><a href="PageStatistiques.php">Statistiques</a></li>
        </ul>
    </nav>

    <div class="container">

        <div class="bloc4">
            <h1>Modification de joueur</h1>
            <?php
            include("ConnexionBDD.php");

            $id_joueur = 0;
            if (isset($_GET['id'])) {
                $id_joueur = intval($_GET['id']);
            }

            $stmt = $linkpdo->prepare("SELECT * FROM joueur WHERE numLicense = :id");
            $stmt->execute(array('id' => $id_joueur));
            $user = $stmt->fetch();
            ?>
            <form action="PageModificationJoueur.php" method="post">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" value="<?php echo $user[1]; ?>">
                <br>
                <label for="prenom">Prenom:</label>
                <input type="text" name="prenom" value="<?php echo $user[3]; ?>">
                <br>
                <label for="dateNaissance">Date de naissance:</label>
                <input type="date" name="dateNaissance" value="<?php echo $user[2]; ?>">
                <br>
                <label for="taille">Taille:</label>
                <input type="text" name="taille" value="<?php echo $user[5]; ?>">
                <br>
                <label for="poids">Poids:</label>
                <input type="text" name="poids" value="<?php echo $user[6]; ?>">
                <br>
                <label for="postePrefere">Poste préféré:</label>
                <input type="text" name="postePrefere" value="<?php echo $user[7]; ?>">
                <br>
                <label for="commentaire">Commentaire:</label>
                <input type="text" name="commentaire" value="<?php echo $user[8]; ?>">
                <br>
                <label for="statut">Statut:</label>
                <input type="text" name="statut" value="<?php echo $user[9]; ?>">
                <br>
                <input type="hidden" name="id" value="<?php echo $id_joueur; ?>">
                <button type="submit" name="modify_submit" id="button">Modifier</button>
            </form>

            <?php

            if (!empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['dateNaissance']) && !empty($_POST['taille']) && !empty($_POST['poids']) && !empty($_POST['postePrefere']) && !empty($_POST['commentaire']) && !empty($_POST['statut'])) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $dateNaissance = $_POST['dateNaissance'];
                $taille = $_POST['taille'];
                $poids = $_POST['poids'];
                $postePrefere = $_POST['postePrefere'];
                $commentaire = $_POST['commentaire'];
                $statut = $_POST['statut'];
                $id_joueur = intval($_POST['id']);

                $stmt = $linkpdo->prepare("UPDATE joueur SET nom=:nom, prenom=:prenom, dateNaissance=:dateNaissance, taille=:taille,
                                 poids=:poids, postePrefere=:postePrefere, commentaire=:commentaire, statut=:statut WHERE numLicense =:id");
                $stmt->execute(array(
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'dateNaissance' => $dateNaissance,
                    'taille' => $taille,
                    'poids' => $poids,
                    'postePrefere' => $postePrefere,
                    'commentaire' => $commentaire,
                    'statut' => $statut,
                    'id' => $id
                ));

                header('Location: GestionEquipe.php');
                exit();
            }
            ?>
        </div>
    </div>
</body>

</html>