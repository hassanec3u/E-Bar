<?php
    $panier = json_decode($_COOKIE["panier"]);
    foreach ($panier as $recette) {
        echo "<p>{$recette}</p>";
    }
?>