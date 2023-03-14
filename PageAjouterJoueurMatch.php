<?php
    session_start();
    ///Connexion au serveur MySQL
    include("ConnexionBDD.php");
    $id_match = $_SESSION['id_match'];
    
    $numLicense = $_POST['joueur'];
    
    $titulaire = true;
    $notation = null;
    $posteMAtch = null;
    $req18 = $linkpdo->prepare("INSERT INTO  participer(numLicense,id_match,notation,titulaire,posteMAtch) VALUES(:numLicense,:id_Match,:notation,:titulaire,:posteMAtch)");
    $req18->execute(array(
        'numLicense' => $numLicense,
        'id_Match' => $id_match,
        'notation' =>  $notation,
        'titulaire' => $titulaire,
        'posteMAtch' => $posteMAtch
    ));
    header("Location: PageMatch.php?id=$id_match");
    exit();

            ?>