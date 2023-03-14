<html lang="fr">
<meta charset = "utf-8">
  <head>
    <title>Inscritpion</title>
    <link rel="stylesheet" href="form.css" />
    <link rel="icon" type="icon/image" href="uploads/t21.jpg" />
  </head>
  <body>
 

    <div class="container">
      <form action="PageInscription.php" method="post" class="bloc">
        <h1>Inscription</h1>
        
        <input type="email" name="email" id="email" placeholder="Email" required />

        <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required />
        <input type="submit" value = "S'inscrire" name="envoie" id="button"/>
        
      </form>
    </div>
  </body>
  <?php
	///Connexion au serveur MySQL
	include("ConnexionBDD.php");
			
	if (!empty($_POST['mdp'])&& !empty($_POST['email'])){
          
        //Déclaration des variables POST
        
        $mdp = $_POST['mdp'];
        $mdp1 = password_hash($mdp,CRYPT_BLOWFISH);
        $email = $_POST['email'];
        echo "$mdp";
        echo "$email";

        //$pp = password_verify($m,$mdp);
        //echo "$pp";        

        ///Préparation de la requête
        $req2 = $linkpdo -> prepare ('INSERT INTO client(email, mdp) VALUES(:email, :mdp)');
        if($req2 == false){
          die('Erreur prepare');
        }
        ///Exécution de la requête
        $req2->execute ( array('email' => $email,
        'mdp' => $mdp1));
        if($req2 == false){
          die('Erreur execute');
        }

        header('Location: PageConnexion.php');
        exit();

    }
			
		?>
</html>