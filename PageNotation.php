<?php session_start(); ?>
<html lang="fr">
<meta charset="utf-8">

<head>
    <title>Notation du joueur</title>
    <link rel="stylesheet" href="PageStyle.css" />
    <link rel="icon" type="icon/image" href="uploads/t21.jpg" />
</head>
<?php
include("ConnexionBDD.php");
$id_joueur = 0;
if (isset($_GET['id'])) {
    $id_joueur = intval($_GET['id']);
}

$id_match = $_SESSION['id_match'] ;
$notation = 0;

?>

<body>
    <div class="container">
        <form action="PageNotation.php" method="post" class="bloc5">

            <label for="email">Note (allant de 1 a 5)</label>
            <input type="number" name="notation" id="notation" min="0" max="5" required  />

            <input type="submit" value="Donner cette note" id="button" />
            <?php
            include("ConnexionBDD.php");
            if(!empty($_POST['notation'])){
            $notation = $_POST['notation'];
            $stmt = $linkpdo->prepare("UPDATE participer SET notation=:notation WHERE numLicense:=numLicense AND id_match:=id_match");
                $stmt->execute(
                    array(
                        ':notation' => $notation,
                        ':numLicense' => $id_joueur,
                        ':id_match' => $id_match
                    )
                );
                header("Location: PageMatch.php?id=$id_match");
                exit();
            }

            ?>
        </form>
    </div>
</body>

</html>