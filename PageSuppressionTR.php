<?php
session_start();

include("ConnexionBDD.php");
 
$id_match = $_SESSION['id_match'] ;

$id = $_GET['id'];

$stmt = $linkpdo->prepare("DELETE FROM participer WHERE numLicense =:id AND id_match =:idM;");
$stmt->execute(array( 'id' => $id, 'idM' =>$id_match));

header("Location: PageMatch.php?id=$id_match");
exit();

?>