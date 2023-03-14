<html lang="fr">
<meta charset="utf-8">

<head>
  <title>Aout de match</title>
  <link rel="stylesheet" href="PageStyle.css" />
  <link rel="icon" type="icon/image" href="uploads/t21.jpg" />
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
    <form action="PageAjouterMatch.php" method="post" class="bloc2">
      <h1>Ajouter un match</h1>


      <input type="text" name="adversaire" placeholder="Nom de l'équipe adversaire" required />

      <input type="date" name="date1" placeholder="Date" required />

      <br>

      <input type="time" name="heure" placeholder="heure" required />

      <input type="boolean" name="domicile" placeholder="Domicile (1 si match a domicile, 0 si match a l'exterieur" required />

      <input type="submit" value="Ajouter ce match" id="button" />
      <input type="button" onclick="window.location.href = 'PageAccueil.php';" value="Annuler" id="button" />
    </form>
  </div>
</body>
<?php
///Connexion au serveur MySQL
include("ConnexionBDD.php");


function InsererMatch($adversaire, $date1, $heure, $domicile)
{
  include("ConnexionBDD.php");

  $req2 = $linkpdo->prepare('INSERT INTO matchvolley(dateMatch, heure, equipeAdverse, Domicile) 
    VALUES(:date1, :heure, :adversaire, :domicile)');
  if ($req2 == false) {
    die('Erreur prepare');
  }
  ///Exécution de la requête
  $req2->execute(array(
    'date1' => $date1,
    'heure' => $heure,
    'adversaire' => $adversaire,
    'domicile' => $domicile
  ));
  if ($req2 == false) {
    die('Erreur execute');
  } else {
    header('Location: PageAccueil.php');
    exit();
  }
}



if (!empty($_POST['adversaire']) && !empty($_POST['date1']) && !empty($_POST['heure']) && !empty($_POST['domicile'])) {
  echo "oui";

  //Déclaration des variables POST
  $adversaire = $_POST['adversaire'];
  $date1 = $_POST['date1'];
  $heure = $_POST['heure'];
  $domicile = $_POST['domicile'];
  

  InsererMatch($adversaire, $date1, $heure, $domicile);
}

?>

</html>