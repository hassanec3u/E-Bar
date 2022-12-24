<?php
include_once "modification_bdd.php";
include "../Donnees.inc.php";

$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

foreach($Recettes as $id => $recette) {
    $titre = $recette["titre"];
    ajouterRecette($mysqli, $id, $titre);
}

?>