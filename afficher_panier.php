<?php
    $panier = json_decode($_COOKIE["panier"]);
    foreach ($panier as $recette) {
        echo htmlentities("<p>{$recette}</p>");
    }
?>