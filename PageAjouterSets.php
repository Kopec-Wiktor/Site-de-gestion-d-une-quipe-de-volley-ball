<?php 
    session_start();
    $id_match = $_SESSION['id_match'];
    $nbSet = $_POST['nbSet'];
    ///Connexion au serveur MySQL
    include("ConnexionBDD.php");

    $scoreDomicile = $_POST['scoreDomicile'];
    $scoreExterieur = $_POST['scoreExterieur'];
    

    $stmt = $linkpdo->prepare("UPDATE matchvolley SET resultatDomicile=?, resultatExterieur=? WHERE id_match=?");
    $stmt->execute(array($scoreDomicile, $scoreExterieur, $id_match));


    for ($i = 1; $i <= $nbSet; $i++) {
        $equipe1 = $_POST[''.$i.'/1'];
        $equipe2 = $_POST[''.$i.'/2'];
        echo"$equipe1 + $equipe2 ";
        ///Préparation de la requête
        $req = $linkpdo -> prepare ('INSERT INTO setDesMatch(numeroSet, resultatDomicile, resultatExterieur, id_match) VALUES(:numeroSet, :resultatDomicile, :resultatExterieur, :id_match)');
        if($req == false){
          die('Erreur prepare');
        }
        ///Exécution de la requête
        $req->execute ( array('numeroSet' => $i,
        'resultatDomicile' => $equipe1,
        'resultatExterieur' => $equipe2,
        'id_match' => $id_match));
        if($req == false){
          die('Erreur execute');
        }
    }

    header('Location: PageMatch.php');
    exit();


?>