<!DOCTYPE HTML>
<meta charset="utf-8">
<html>
  <head lang="fr">
    <title>Modification de Match</title>
    <link rel="stylesheet" href="PageStyle.css" />
    <link rel="icon" type="icon/image" href="uploads/t21.jpg" />
  </head>
  <body>
  <header>
  <nav>
        <ul>
            <li><a href="PageAccueil.php">Accueil</a></li>
            <li><a href="GestionEquipe.php">Gestion des joueur</a></li>
            <li><a href="PageGestionMatch.php">Gestion des matchs</a></li>
            <li><a href="PageStatistiques.php">Statistiques</a></li>
        </ul>
    </nav>
</header>
    <div class="container">
      <div class="bloc2">
        <h1>Modifier un match</h1>

        <?php
        // Connexion à la base de données
        include("ConnexionBDD.php");

        // Vérifier si l'id_match du membre a été passé en paramètre
        $id_match = 0;
        if (isset($_GET['id'])) {
          $id_match = intval($_GET['id']);
        }

        // Préparer la requête pour récupérer les données du membre
        $stmt = $linkpdo->prepare("SELECT * FROM matchvolley WHERE id_match=:id");
        $stmt->execute(array('id' => $id_match));
        $match = $stmt->fetch();
       
        // Afficher le formulaire de modification
        ?>
        <form action="PageModificationMatch.php" method="post">
          <label for="dateMatch">Date du Match:</label>
          <input type="date" id="dateMatch" name="dateMatch" value="<?php echo $match['dateMatch']; ?>"><br>
          <label for="heure">Heure:</label>
          <input type="time" id="heure" name="heure" value="<?php echo $match['heure']; ?>"><br>
          <label for="equipeAdverse">Equipe Adverse:</label>                    
          <input type="text" id="equipeAdverse" name="equipeAdverse" value="<?php echo $match['equipeAdverse']; ?>"><br>
          <label for="Domicile">Domicile:</label>
          <input type="text" id="Domicile" name="Domicile" value="<?php echo $match['Domicile']; ?>"><br>
          <label for="resultatDomicile">Resultat Domicile:</label>
          <input type="text" id="resultatDomicile" name="resultatDomicile" value="<?php echo $match['resultatDomicile']; ?>"><br>
          <label for="">Resultat Exterieur:</label>
          <input type="text" id="resultatExterieur" name="resultatExterieur" value="<?php echo $match['resultatExterieur']; ?>"><br>
          <input type="hidden" name="id" value="<?php echo $id_match; ?>">
          <input type="submit" value="Modifier" id='button'>
          
        </form>
        
        <?php
        // Vérifier si le formulaire a été soumis
        if (isset($_POST['dateMatch']) && isset($_POST['heure']) && isset($_POST['equipeAdverse']) && isset($_POST['Domicile']) && isset($_POST['resultatDomicile']) && isset($_POST['resultatExterieur']) && isset($_POST['id'])) {
            // Récupérer les données du formulaire
            $id_match = intval($_POST['id']);
            $dateMatch = $_POST['dateMatch'];
            $heure = $_POST['heure'];
            $equipeAdverse = $_POST['equipeAdverse'];
            $Domicile = $_POST['Domicile'];
            $resultatDomicile = $_POST['resultatDomicile'];
            $resultatExterieur = $_POST['resultatExterieur'];

            // Mettre à jour les données du membre dans la base de données
            $stmt = $linkpdo->prepare("UPDATE matchvolley SET dateMatch = :dateMatch, heure = :heure, equipeAdverse = :equipeAdverse,
             Domicile = :Domicile, resultatDomicile = :resultatDomicile, resultatExterieur = :resultatExterieur WHERE id_match = :id_match");
                $stmt->execute(array(
                    ':dateMatch' => $dateMatch,
                    ':heure' => $heure,
                    ':equipeAdverse' => $equipeAdverse,
                    ':Domicile' => $Domicile,
                    ':resultatDomicile' => $resultatDomicile,
                    ':resultatExterieur' => $resultatExterieur,
                    ':id_match' => $id_match
                ));
        
                header('Location: PageGestionMatch.php');
                exit();
                }
                        
           ?>
         </div>
         </div>
         </body>
         </html>
         
