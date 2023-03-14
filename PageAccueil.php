<!DOCTYPE HTML>
<meta name="viewport" content="width=device-width" charset="utf-8">
<html>

<head lang="fr">
    <title>Page d'Accueil</title>
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
    function AfficherProchainMatch()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");

        $res = $linkpdo->query('SELECT id_match, Domicile, equipeAdverse, dateMatch, heure FROM matchvolley WHERE dateMatch >= DATE( NOW() )ORDER BY dateMatch asc ');
        $matchProchain = $res->fetch();
        if($matchProchain != false){
            echo "<a href=\"PageMatch.php?id=$matchProchain[0]\" title= \"Voir les détail du match\"><div class=\"bloc2\">";
        if ($matchProchain[1]) {
            echo "Toulouse vs $matchProchain[2]";
        } else {
            echo "$matchProchain[2] vs Toulouse";
        }
        echo " Le $matchProchain[3]
        à $matchProchain[4]
        </div></a>";
        }else{
            echo"Il n'y a pas de prochain match";
        }
        
    }

    function AfficherMatchTermine()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");

        $res = $linkpdo->query('SELECT id_match, Domicile, equipeAdverse, dateMatch, resultatDomicile, resultatExterieur  FROM matchvolley WHERE dateMatch < DATE( NOW() )ORDER BY dateMatch asc ');
        $matchTermine = $res->fetchAll();
        foreach ($matchTermine as $val) {

            echo "<a href=\"PageMatch.php?id=$val[0]\" title= \"Voir les détail du match\"><div class=\"bloc2\">";
            if ($val[1]) {
                echo "Toulouse vs $val[2]";
            } else {
                echo "$val[2] vs Toulouse";
            }
            echo " Le $val[3]";
            if ($val[1]) {
                echo "Score: $val[4] : $val[5]";
            } else {
                echo "Score: $val[5] : $val[4]";
            }
            echo "</div></a>";
        }
    }

    function AfficherMatchAVenir()
    {
        ///Connexion au serveur MySQL
        include("ConnexionBDD.php");

        $res = $linkpdo->query('SELECT id_match, Domicile, equipeAdverse, dateMatch, heure FROM matchvolley WHERE dateMatch > DATE( NOW() )ORDER BY dateMatch desc ');
        $matchAVenir = $res->fetchAll();

        foreach ($matchAVenir as $val) {

            echo "<a href=\"PageMatch.php?id=$val[0]\" title= \"Voir les détail du match\"><div class=\"bloc2\">";
            if ($val[1]) {
                echo "Toulouse vs $val[2]";
            } else {
                echo "$val[2] vs Toulouse";
            }
            echo " Le $val[3]
            à $val[4]
            </div></a>";
        }
    }


    ?>
    <div class="container">

        <div call="bloc2">

            <h1>Match à venir</h1>
            <?php


            AfficherMatchAVenir()

            ?>
        </div>
        <div call="bloc2">
            <h1>Prochain match</h1>
            <?php


            AfficherProchainMatch();

            ?>
        </div>

        <div call="bloc2">
            <h1>Match terminé</h1>
            <?php


            AfficherMatchTermine();

            ?>
        </div>
        <input type="submit" onclick="window.location.href= 'PageAjouterMatch.php';" value="Ajoutez un Match" id="button">

    </div>
</body>

</html>