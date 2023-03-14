<?php


include("ConnexionBDD.php");


$id = $_GET['id'];


$stmt = $linkpdo->prepare("DELETE FROM participer WHERE id_match =:id;");
$stmt->execute(array( 'id' => $id));

$stmt = $linkpdo->prepare("DELETE FROM matchvolley WHERE id_match =:id;");
$stmt->execute(array( 'id' => $id));

$stmt = $linkpdo->prepare("DELETE FROM setdesmatch WHERE id_match =:id;");
$stmt->execute(array( 'id' => $id));

header('Location: PageGestionMatch.php');

?>