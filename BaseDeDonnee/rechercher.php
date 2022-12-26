<?php

include_once "modification_bdd.php";


$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");
$rec = rechercher($mysqli, $_GET["rec"]);
$mysqli->close();

foreach ($rec as $recette) {
    echo "<p>" . $recette["titreR"] . "</p>";
}

echo 'ok';

?>