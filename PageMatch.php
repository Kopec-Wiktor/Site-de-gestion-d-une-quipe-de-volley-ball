<?php
session_start();
?>
<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width" charset="utf-8">
<html>

<head lang="fr">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="PageStyle.css" />
</head>

<body>
    <?php //recup l'id
    if (isset($_GET['id'])) {
        $id_match = $_GET['id'];
        $_SESSION['id_match'] = $id_match;
    } else {
        $id_match = $_SESSION['id_match'];
    }
    ?>

    <nav>
        <ul>
            <li><a href="PageAccueil.php">Accueil</a></li>
            <li><a href="GestionEquipe.php">Gestion des joueur</a></li>
            <li><a href="PageGestionMatch.php">Gestion des matchs</a></li>
            <li><a href="PageStatistiques.php">Statistiques</a></li>
        </ul>
    </nav>


    <?php

    //Verifie s'il existe un score pour ce match, return le score des sets si oui et false sinon
    function ScoreExiste($id_match)
    {

        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $req21 = $linkpdo->prepare('SELECT * FROM setDesMatch WHERE id_match = ? ORDER BY numeroSet');
        if ($req21 == false) {
            die('Erreur linkpdo');
        }
        $req21->execute(array($id_match));
        if ($req21 == false) {
            die('Erreur execute');
        }
        $SetExiste = $req21->fetchAll();
        if ($SetExiste == false) {
            return false;
        } else {
            return $SetExiste;
        }
    }

    //affiche le résultat du match avec les différent score de chaque sets
    function AfficheResultatMatch($id_match)
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $req18 = $linkpdo->prepare('SELECT * FROM matchvolley WHERE id_match = ?');
        if ($req18 == false) {
            die('Erreur linkpdo');
        }
        $req18->execute(array($id_match));
        if ($req18 == false) {
            die('Erreur execute');
        }
        $InfoMatch = $req18->fetch();
        if ($InfoMatch[1]) {
            echo "<h1>Toulouse vs $InfoMatch[3]</h1>";
        } else {
            echo "<h1>$InfoMatch[3] vs Toulouse</h1>";
        }
        echo "<br>";
        if ($InfoMatch[1]) {
            echo "<h1>Score: $InfoMatch[5] - $InfoMatch[6]</h1>";
        } else {
            echo "<h1>Score: $InfoMatch[6] - $InfoMatch[5]</h1>";
        }



        $data_Match = ScoreExiste($id_match);
        foreach ($data_Match as $val) {
            echo "<div> Résultat set $val[1] : $val[2] - $val[3] </div>";
        }
    }
    function SelectJoueur()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        //Preparation requete
        $req = $linkpdo->query('SELECT numLicense, Nom FROM joueur');
        if ($req == false) {
            die('Erreur linkpdo');
        }

        $data = $req->fetchAll();

        return $data;
    }
    //Formulaire pour titulaire
    function ListeJoueurTitulaire($data)
    {
        $titulaire = true;
        echo "<form action=\"PageAjouterJoueurMatch.php\" method=\"post\" class=\"bloc\">";
        echo "<select name=\"joueur\" id=\"pet-select\" required>
              <option value=\"\" selected disabled hidden>--Merci de choisir un joueur--</option>";
        foreach ($data as $val) {
            echo "<option value=\"$val[0]\">$val[1]</option>";
        }
        echo "
        </select> <input type=\"submit\" value=\"Ajouter ce joueur Titulaire\" id=\"button1\">";
        echo "</form>";
    }

    //formulaire pour remplacant
    function ListeJoueurRemplacant($data)
    {
        $titulaire = false;
        echo "<form action=\"PageAjouterJoueurMatch2.php\" method=\"post\" class=\"bloc\">";
        echo "<select name=\"joueur\" id=\"pet-select\" required>
              <option value=\"\" selected disabled hidden>--Merci de choisir un joueur--</option>";
        foreach ($data as $val) {
            echo "<option value=\"$val[0]\">$val[1]</option>";
        }
        echo "
        </select> <input type=\"submit\" value=\"Ajouter ce joueur remplacant\" id=\"button2\">";
        echo "</form>";
    }
    //ajoute un score pour ce match
    function AjouterUnScore()
    {
    }
    //vérifie s'il ya u resultat pour ce match 
    function ResultatExiste()
    {
    }

    ?>

    <?php
    if (ScoreExiste($id_match)) {
        AfficheResultatMatch($id_match);
    } else {
        echo "
            <form action=\"PageMatch.php\" method=\"post\" class=\"bloc\">
        <h1>Rentrer le résultat du match</h1>
        <div>
            <select name=\"scoreDomicile\" id=\"score\" required>
                <option value=\"0\">0</option>
                <option value=\"1\">1</option>
                <option value=\"2\">2</option>
                <option value=\"3\">3</option>
            </select>
            <select name=\"scoreExterieur\" id=\"score\" required>
                <option value=\"0\">0</option>
                <option value=\"1\">1</option>
                <option value=\"2\">2</option>
                <option value=\"3\">3</option>
            </select>
        </div>

        <input type=\"submit\" value=\"rentrer le score\" name=\"button\" />
        </form>";
    }
    ?>


    <br>

    <?php
    if (isset($_POST['button'])) {
        $scoreDomicile = $_POST['scoreDomicile'];
        $scoreExterieur = $_POST['scoreExterieur'];


        $nbSet = $scoreDomicile + $scoreExterieur;
        if ($nbSet < 3 or $nbSet > 5 or ($scoreDomicile == 2 && $scoreExterieur == 2)) {
            echo "<p style='color:red'>merci de rentrer un resultat correct</p> ";
        }
        echo "<form action=\"PageAjouterSets.php\" method=\"post\" class =\"bloc\" ";
        for ($i = 1; $i <= $nbSet; $i++) {
            echo "<div class =\"bloc1\">
                        <label for=\"$i/1\">Score set $i:</label>  <input type=\"number\" placeholder=\"25\" name=\"$i/1\" max=\"25\" min=\"0\" > 
                        <label for=\"$i/2\">à</label><input type=\"number\" placeholder=\"25\" name=\"$i/2\" max=\"25\" min=\"0\" >
                        <input  type=\"hidden\" name=\"nbSet\" value=\"$i\"> 
                        <input  type=\"hidden\" name=\"scoreDomicile\" value=\"$scoreDomicile\"> 
                        <input  type=\"hidden\" name=\"scoreExterieur\" value=\"$scoreExterieur\"> 
                        </div> ";
        }
        echo "<input type=\"submit\" value = \"rentrer le score des sets\" name=\"button\" /> </form>";
    }


    ?>






    <div class="bloc">

        <h1>Titulaires</h1>
        <p>max: 6</p>
        <?php
        include("ConnexionBDD.php");

        $stmt = $linkpdo->prepare("SELECT j.photo, j.nom, j.prenom, j.postePrefere, j.commentaire, p.notation, j.numLicense
         FROM joueur j, participer p WHERE j.numLicense = p.numLicense AND p.titulaire = 1 AND p.id_match = ? ORDER BY nom");
        $stmt->execute(array($id_match));

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
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>poste</th>
                        <th>photo</th>
                        
                        <th>Actions</th>
                    </tr>';
            while ($user = $stmt->fetch()) {
        ?>
                <tr>

                    <td><?php echo $user[1]; ?></td>
                    <td><?php echo $user[2]; ?></td>
                    <td><?php echo $user[3]; ?></td>
                    <td><img class="photoJoueur" src="<?php echo $user[0]; ?>"></td>
                    <td><?php
                        echo '<a href=PageNotation.php?id=' . $user[6] . '>Noter ce joueur</a></br>';
                        echo '<a href=PageSuppressionTR.php?id=' . $user[6]
                            . ' onclick="return confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\');">Supprimer</a>';

                        ?></td>
                </tr>
        <?php
            }
            echo '</table>';
        } ?>



        <h3>Choix du joueur</h3>

        <div>
            <?php
            ListeJoueurTitulaire(SelectJoueur());

            ?>
        </div>







    </div>

    <div class="bloc">

        <h1>Remplacants</h1>
        <p>max: 6</p>
        <?php
        include("ConnexionBDD.php");

        $stmt = $linkpdo->prepare("SELECT j.photo, j.nom, j.prenom, j.postePrefere, j.commentaire, p.notation, j.numLicense
 FROM joueur j, participer p WHERE j.numLicense = p.numLicense AND p.titulaire = 0 AND p.id_match = ? ORDER BY nom");
        $stmt->execute(array($id_match));

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
                <th>Nom</th>
                <th>Prenom</th>
                <th>poste</th>
                <th>photo</th>
                
                <th>Actions</th>
            </tr>';
            while ($user = $stmt->fetch()) {
        ?>
                <tr>

                    <td><?php echo $user[1]; ?></td>
                    <td><?php echo $user[2]; ?></td>
                    <td><?php echo $user[3]; ?></td>
                    <td><img class="photoJoueur" src="<?php echo $user[0]; ?>"></td>
                    <td><?php
                        echo '<a href=PageNotation.php?id=' . $user[6] . '>Noter ce joueur</a></br>';
                        echo '<a href=PageSuppressionTR.php?id=' . $user[6]
                            . ' onclick="return confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\');">Supprimer</a>';

                        ?></td>
                </tr>
        <?php
            }
            echo '</table>';
        } ?>



        <h3>Choix du joueur</h3>

        <div>
            <?php
            ListeJoueurRemplacant(SelectJoueur());

            ?>
        </div>







    </div>


    <input type="submit" onclick="window.location.href= 'PageAccueil.php';" value="retour" id="button">
</body>

</html>