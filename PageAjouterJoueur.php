<html lang="fr">
<meta charset = "utf-8">
  <head>
    <title>Aout de joueur</title>
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

    <div class="bloc2">
      <form action="PageAjouterJoueur.php" method="post">
        <h1>Ajouter un joueur</h1>


        <input type="text" name="Licence" placeholder="Numéro de licence" required />

        <input type="text" name="nom" placeholder="Nom" required />

          
          
          <input type="text" name="prenom" placeholder="Prénom" required />

          <input type="date" name="dn" id="dn" placeholder="Date de naissance" required />

          <input type="text" name="taille" placeholder="taille" required />

          <input type="text" name="poids" placeholder="poids" required />

          <input type="text" name="postePref" placeholder="Poste Preferer" required />

          <input type="text" name="com" placeholder="commentaire"  />

          <label for="pet-select">Statut:</label>

        <select name="statut" id="statut">
            <option value="Actif">Actif</option>
            <option value="Blessé">Blessé</option>
            <option value="Suspendu">Suspendu</option>
            <option value="Absent">Absent</option>
        </select>
    
          <div>
        
          <label for="imgJoueur">Veuillez séléctionnez une image de profil pour le joueur, format requis: jpg, jpeg, gif ou png.</label>
          <input type="file" id="imgJoueur" name="imgJoueur" />
        </div>
        <input type="submit" value = "S'inscrire" id="button"/>
        <input type="button" onclick="window.location.href = 'PageAccueil.php';" value="Annuler" id="button"/>
      </form>
    </div>
  </body>
  <?php
	///Connexion au serveur MySQL
  include("ConnexionBDD.php");
  function NumLicenceExiste($NumLicence){
    include("ConnexionBDD.php");

    $reqLicence = $linkpdo -> prepare('SELECT numLicense FROM joueur WHERE numLicense = ?');
    if($reqLicence == false){
        die('Erreur linkpdo');
    }

    $reqLicence -> execute(array($NumLicence));
    if($reqLicence == false){
        die('Erreur execute');
    }

    $LicenceJoueur = $reqLicence -> fetch();
    //si le num existe deja return vrai sinon false
    if($LicenceJoueur == true){
      return true;
    }else{
      return false;
    }
  }

  function InsererJoueur($numLicence, $nom, $prenom, $dn, $photo, $taille,$poids, $posteprefere, $commentaire, $statut){
    include("ConnexionBDD.php");
    
    $req2 = $linkpdo -> prepare ('INSERT INTO joueur(numLicense, nom, dateNaissance, prenom, photo, taille, poids, postePrefere, commentaire, statut) 
    VALUES(:numLicense, :nom, :dateNaissance, :prenom, :photo, :taille, :poids, :postePrefere, :commentaire, :statut)');
    if($req2 == false){
      die('Erreur prepare');
    }
    ///Exécution de la requête
    $req2->execute ( array('numLicense' => $numLicence,
    'nom' => $nom,
    'dateNaissance' => $dn,
    'prenom' => $prenom,
    'photo' => $photo,
    'taille' => $taille,
    'poids' => $poids,
    'postePrefere' => $posteprefere,
    'commentaire' => $commentaire,
    'statut' => $statut));
    if($req2 == false){
      die('Erreur execute');
    }else{
      header('Location: PageAccueil.php');
      exit();
    }
  }

  function BonneExtension($file){
    if (in_array($extension, $allowedExtensions)){
      move_uploaded_file($_FILES['imgJoueur']['tmp_name'], 'uploads/' . basename($_FILES['imgJoueur']['name']));
    }
  }

	if (!empty($_POST['Licence']) && !empty($_POST['nom']) && !empty($_POST['prenom'])&& !empty($_POST['dn'])&& !empty($_POST['taille'])&& !empty($_POST['poids'])&& !empty($_POST['postePref'])&& !empty($_POST['statut'])){
    echo"oui";
        
        //Déclaration des variables POST
        $numLicence = $_POST['Licence'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $dn = $_POST['dn'];
        $taille = $_POST['taille'];
        $poids = $_POST['poids'];
        $posteprefere = $_POST['postePref'];
        $commentaire = $_POST['com'];
        $statut = $_POST['statut'];
        $photo = null;

        if(NumLicenceExiste($numLicence)){
          echo"Le numero de licence saisit est deja utiliser par un autre joueur";
        }else{
          InsererJoueur($numLicence, $nom, $prenom, $dn, $photo, $taille,$poids, $posteprefere, $commentaire, $statut);
        }

      }
			
		?>
</html>