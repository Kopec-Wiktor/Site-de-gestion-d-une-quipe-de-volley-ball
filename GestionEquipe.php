<!DOCTYPE HTML>
<meta charset="utf-8">
<html>

<head lang="fr">
    <title>Gestion de l'équipe</title>
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

        <div class="bloc2">
            <h1>Gestion de l'équipe</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="text" name="search_name" placeholder="Rechercher par nom">
                <button type="submit" name="search_submit" id="button">Rechercher</button>
            </form>
            <?php
            include("ConnexionBDD.php");
            $stmt = $linkpdo->prepare("SELECT * FROM joueur ORDER BY nom");
            $stmt->execute(array());
            if (isset($_POST['search_submit'])) {
                $nom = $_POST['search_name'];
                if (empty($nom)) {
                    $stmt = $linkpdo->prepare("SELECT * FROM joueur ORDER BY nom");
                    $stmt->execute(array());
                } else {
                    $stmt = $linkpdo->prepare("SELECT * FROM joueur WHERE nom LIKE :nom ORDER BY nom");
                    $nom = '%' . $nom . '%';
                    $stmt->execute(array('nom' => $nom));
                }
            }

            if (!$stmt->rowCount()) {
                echo "Aucun contact correspondant dans la base de donnée";
            } else {
                echo '<style>
                    html {
                      font-family: sans-serif;
                    }
                    table {
                      border-collapse: collapse;
                      border: 2px solid rgb(200,200,200);
                      letter-spacing: 1px;
                      font-size: 0.8rem;
                    }
                    td, th {
                      border: 1px solid rgb(190,190,190);
                      padding: 10px 20px;
                    }
                    td {
                      text-align: center;
                    }
                    caption {
                      padding: 10px;
                    }
                </style>';
                echo '<table>
                    <tr>
                        <th>Licence</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Date de naissance</th>
                        <th>Photo</th>
                        <th>Taille</th>
                        <th>Poids</th>
                        <th>Poste préféré</th>
                        <th>Commentaire</th>
                        <th>Statut</th>
                    </tr>';
                while ($user = $stmt->fetch()) {
            ?>
                    <tr>

                        <td><?php echo $user[0]; ?></td>
                        <td><?php echo $user[1]; ?></td>
                        <td><?php echo $user[3]; ?></td>
                        <td><?php echo $user[2]; ?></td>
                        <td><img class="photoJoueur" src="<?php echo $user[4]; ?>"></td>
                        <td><?php echo $user[5]; ?></td>
                        <td><?php echo $user[6]; ?></td>
                        <td><?php echo $user[7]; ?></td>
                        <td><?php echo $user[8]; ?></td>
                        <td><?php echo $user[9]; ?></td>
                        <td><?php
                            echo '<a href=PageModificationJoueur.php?id=' . $user[0] . '>Modifier</a></br>';

                            echo '<a href=PageSuppressionJoueur.php?id=' . $user[0]
                                . ' onclick="return confirm(\'Etes-vous sûr de vouloir supprimer ce joueur?\');">Supprimer</a>';

                            ?></td>
                    </tr>
            <?php
                }
                echo '</table>';
            }




            ?>
        </div>
    </div>

    <div class="bloc3">
        <form action="GestionEquipe.php" method="post" enctype='multipart/form-data'>
            <h1>Ajouter un joueur</h1>


            <input type="text" name="Licence" placeholder="Numéro de licence" required />

            <input type="text" name="nom" placeholder="Nom" required />



            <input type="text" name="prenom" placeholder="Prénom" required />

            <input type="date" name="dateNaissance" id="dateNaissance" placeholder="Date de naissance" required />

            <input type="text" name="taille" placeholder="taille" required />

            <input type="text" name="poids" placeholder="poids" required />

            <input type="text" name="postePref" placeholder="Poste Preferer" required />

            <input type="text" name="com" placeholder="commentaire" />

            <label for="pet-select">Statut:</label>

            <select name="statut" id="statut">
                <option value="Actif">Actif</option>
                <option value="Blessé">Blessé</option>
                <option value="Suspendu">Suspendu</option>
                <option value="Absent">Absent</option>
            </select>

            <div>

                <label for="photo">Veuillez séléctionnez une image de profil pour le joueur, format requis: jpg, jpeg, gif ou png.</label>
                <input type="file" id="photo" name="photo" required />
            </div>
            <input type="submit" value="Ajouter" id="button" />
        </form>
    </div>
</body>
<?php
///Connexion au serveur MySQL
include("ConnexionBDD.php");
function NumLicenceExiste($NumLicence)
{
    include("ConnexionBDD.php");

    $reqLicence = $linkpdo->prepare('SELECT numLicense FROM joueur WHERE numLicense = ?');
    if ($reqLicence == false) {
        die('Erreur linkpdo');
    }

    $reqLicence->execute(array($NumLicence));
    if ($reqLicence == false) {
        die('Erreur execute');
    }

    $LicenceJoueur = $reqLicence->fetch();
    //si le num existe deja return vrai sinon false
    if ($LicenceJoueur == true) {
        return true;
    } else {
        return false;
    }
}

if (!empty($_POST['Licence']) && !empty($_POST['nom']) && !empty($_POST['prenom'])  && !empty($_POST['dateNaissance']) && !empty($_POST['taille']) && !empty($_POST['poids']) && !empty($_POST['postePref']) && !empty($_POST['statut'])) {
    include("ConnexionBDD.php");

    //Déclaration des variables POST
    $numLicence = $_POST['Licence'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['dateNaissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $posteprefere = $_POST['postePref'];
    $commentaire = $_POST['com'];
    $statut = $_POST['statut'];
    $photo = $_FILES['photo']['name'];
    $photo = 'uploads/photoJoueur/' . basename($_FILES['photo']['name']);
    if ($_FILES['photo']['size'] <= 8000000) {
        //on récupère l'extension du fichier dans $extension
        $fileInfo = pathinfo($_FILES['photo']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (in_array($extension, $allowedExtensions)) {
            // On peut valider le fichier et le stocker définitivement
            move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/photoJoueur/' . basename($_FILES['photo']['name']));
            $req2 = $linkpdo->prepare('INSERT INTO joueur(numLicense, nom, dateNaissance, prenom, photo, taille, poids, postePrefere, commentaire, statut) 
        VALUES(:numLicense, :nom, :dateNaissance, :prenom, :photo, :taille, :poids, :postePrefere, :commentaire, :statut)');
            if ($req2 == false) {
                die('Erreur prepare');
            }
            $req2->execute(array(
                'numLicense' => $numLicence,
                'nom' => $nom,
                'dateNaissance' => $dateNaissance,
                'prenom' => $prenom,
                'taille' => $taille,
                'poids' => $poids,
                'postePrefere' => $posteprefere,
                'commentaire' => $commentaire,
                'statut' => $statut,
                'photo' => $photo
            ));
            if ($req2 == false) {
                die('Erreur execute');
            }
        } else {
            echo "Le fichier choisit doit avoir l'extension png, jpg, jpeg ou gif";
        }
    } else {
        echo "fichier trop volumineux";
    }
    header('Location: GestionEquipe.php');
    exit();
}


?>

</body>

</html>