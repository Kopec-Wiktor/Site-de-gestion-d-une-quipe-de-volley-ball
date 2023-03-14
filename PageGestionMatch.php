<!DOCTYPE HTML>
<meta charset="utf-8">
<html>

<head lang="fr">
    <title>Gestion des matchs</title>
    <link rel="stylesheet" href="PageStyle.css" />
</head>

<body>
    <nav>
        <ul>
            <li><a href="PageAccueil.php">Accueil</a></li>
            <li><a href="GestionEquipe.php">Gestion des joueur</a></li>
            <li><a href="PageGestionMatch.php">Gestion des matchs</a></li>
            <li><a href="PageStatistiques.php">Statistiques</a></li>
        </ul>
    </nav>


    <div class="container">

        <div class="bloc2">
            <h1>Gestion des matchs</h1>
            
            <?php
            include("ConnexionBDD.php");
            
                $stmt = $linkpdo->prepare("SELECT * FROM matchvolley ORDER BY dateMatch");
                $stmt->execute(array());
          
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
                        <th>Date du match</th>
                        <th>Heure</th>
                        <th>Equipe Adverse</th>
                        <th>Domicile</th>
                        <th>Resultat Domicile</th>
                        <th>ResulstatExterieur</th>
                    </tr>';
                while ($user = $stmt->fetch()) {
            ?>
                    <tr>

                        <td><?php echo $user[1]; ?></td>
                        <td><?php echo $user[2]; ?></td>
                        <td><?php echo $user[3]; ?></td>
                        <td><?php echo $user[4]; ?></td>
                        <td><?php echo $user[5]; ?></td>
                        <td><?php echo $user[6]; ?></td>
                        <td><?php
                            echo '<a href=PageModificationMatch.php?id=' . $user[0] . '>Modifier</a></br>';
                            if ($user[0] !== "13") {
                                echo '<a href=PageSuppressionMatch.php?id=' . $user[0]
                                    . ' onclick="return confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\');">Supprimer</a>';
                            }
                            ?></td>
                    </tr>
            <?php
                }
                echo '</table>';
            }




            ?>
        </div>
    </div>



</body>

</html>