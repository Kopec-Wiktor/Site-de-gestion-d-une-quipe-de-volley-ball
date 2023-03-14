<?php session_start(); ?>
<html lang="fr">
<meta charset = "utf-8">
  	
  <head>
    <title>Connexion</title>
    <link rel="stylesheet" href="PageStyle.css" />
    <link rel="icon" type="icon/image" href="uploads/t21.jpg" />
  </head>
  <body>
      <div class="container">
      <form action="PageConnexion.php" method="post" class="bloc5">
        <h1>Connexion</h1>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required />
        <label for="mot de passe">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" required />
        <input type="submit" value = "Se connecter" id="button"/>
        <?php

            //function VérificationMDP($mdp)
            //{
            //echo "Exemple de fonction.\n";
            //return $mdpCorrect;
            //}
    ///Connexion au serveur MySQL
    include("ConnexionBDD.php");

      if (!empty($_POST['email']) && !empty($_POST['mdp'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        //vérifier que le mdp rentré est correct
        $req = $linkpdo -> prepare('SELECT mdp FROM client WHERE email = ?');
        if($req == false){
          die('Erreur linkpdo');
        }

        $req -> execute(array($email));
        if($req == false){
          die('Erreur execute');
        }

        $mdpClient = $req -> fetch();
    
        if(password_verify($_POST['mdp'],$mdpClient[0])){
          header('Location: PageAccueil.php');
          exit();
        }else{
          echo"<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
        }
      }

  ?>
      </form>
      </div>
  </body>
  
</html>