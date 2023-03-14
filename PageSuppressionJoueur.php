<?php


include("ConnexionBDD.php");


$id = $_GET['id'];


$stmt = $linkpdo->prepare("DELETE FROM participer WHERE numLicense =:id;");
$stmt->execute(array( 'id' => $id));

$stmt = $linkpdo->prepare("DELETE FROM joueur WHERE numLicense =:id;");
$stmt->execute(array( 'id' => $id));


header('Location: GestionEquipe.php');

?>