<?php

include_once "modification_bdd.php";
include_once "../Donnees.inc.php";



$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");
$rec = rechercher($mysqli, $_GET["rec"]);
$mysqli->close();

foreach ($rec as $recette) {
    echo "<p>" . $recette["titreR"] . "</p>";
}

foreach ($Hierarchie as $Aliment => $Details) {
    $pattern = "/". $_GET["rec"] .".*/m";

    if (preg_match($pattern, $Aliment)) {
        if (isset($Details["sous-categorie"])) {
            foreach ($Details["sous-categorie"] as $AlimentSousCategorie) {
                echo "<p>" . $AlimentSousCategorie . "</p>";
            }
        }
    }    
}

echo 'ok';

?>