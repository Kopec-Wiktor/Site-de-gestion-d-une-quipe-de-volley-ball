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
    <?php
    //return le nb de match gagné
    function NbMatchGagner()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $res = $linkpdo->query('SELECT count(resultatDomicile) FROM matchvolley WHERE Domicile = 1 AND resultatDomicile = 3');
        $nbMatchGagne = $res->fetch();
        return $nbMatchGagne[0];
    }
    //return le nb de match qui on était joué
    function NbMatchTotalJouer()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $res = $linkpdo->query('SELECT count(resultatDomicile) FROM matchvolley WHERE resultatDomicile IS NOT NULL');
        $nbMatchJouer = $res->fetch();
        return $nbMatchJouer[0];
    }
    //return le nb de match perdu
    function NbMatchPerdu($matchGagner, $matchTotalJouer)
    {
        return $matchTotalJouer - $matchGagner;
    }
    //return le poucentage de match gagner 
    function PourcentageVictoire($matchGagner, $matchTotalJouer)
    {
        return $matchGagner / $matchTotalJouer * 100;
    }
    //return le pourcentage des defaite
    function PourcentageDefaite($PourcentageVictoire)
    {
        return 100 - $PourcentageVictoire;
    }
    //return le nb de match joué titulaire
    function NbMatchTitulaire($numLicense)
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $req21 = $linkpdo->prepare('SELECT count(numLicense) FROM participer WHERE titulaire = 1 AND numLicense = ?');
        if ($req21 == false) {
            die('Erreur linkpdo');
        }
        $req21->execute(array($numLicense));
        if ($req21 == false) {
            die('Erreur execute');
        }
        $NbMatchTitulaire = $req21->fetch();
        return $NbMatchTitulaire[0];
        
    }

    //return le nb de match joué remplacant
    function NbMatchRemplacant($numLicense)
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");
        $req21 = $linkpdo->prepare('SELECT count(numLicense) FROM participer WHERE titulaire = 0 AND numLicense = ?');
        if ($req21 == false) {
            die('Erreur linkpdo');
        }
        $req21->execute(array($numLicense));
        if ($req21 == false) {
            die('Erreur execute');
        }
        $NbMatchTitulaire = $req21->fetch();
        return $NbMatchTitulaire[0];
        
    }




    ?>
    <div class="bloc2">
        <h1>Statistique de Toulouse</h1>
    <div>

    <div class="bloc2">
        <?php //select count les match gagne a domicile
        $NbMatchGagner = NbMatchGagner();
        $NbMatchTotalJouer = NbMatchTotalJouer();
        $NbMatchPerdu = NbMatchPerdu(NbMatchGagner(), NbMatchTotalJouer());
        $PourcentageVictoire = PourcentageVictoire(NbMatchGagner(), NbMatchTotalJouer());
        $PourcentageDefaite = PourcentageDefaite($PourcentageVictoire);
        echo "
            Match gagné : $NbMatchGagner soit $PourcentageVictoire %, match perdu $NbMatchPerdu soit $PourcentageDefaite %
            ";
        ?>
    </div>


    <div class="bloc2">
    <?php
    
    include("ConnexionBDD.php");

    $stmt = $linkpdo->prepare("SELECT j.numLicense, j.photo, j.statut, j.postePrefere FROM joueur j");
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
                <th>Photo Joueur</th>
                <th>Statut</th>
                <th>Poste Prefere</th>
                <th>Nombre match joué titulaire</th>
                <th>Nombre match joué remplacant</th>
                <th>Moyenne des notations</th>
                <th>Pourcentage match gagné lors des participation</th>
            </tr>';
        while ($user = $stmt->fetch()) {
            $NbMatchTitulaire = NbMatchTitulaire($user[0]);
            $NbMatchRemplacant = NbMatchRemplacant($user[0]);
    ?>
            <tr>

                <td><img class="photoJoueur" src="<?php echo $user[1]; ?>"></td>
                <td><?php echo $user[2]; ?></td>
                <td><?php echo $user[3]; ?></td>
                <td><?php echo $NbMatchTitulaire; ?></td>
                <td><?php echo $NbMatchRemplacant; ?></td>
                <td></td>
                <td></td>
            </tr>
    <?php
        }
        echo '</table>';
    }




    ?>
    </div>


</body>

</html>