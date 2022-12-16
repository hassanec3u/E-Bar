<?php
    if (!isset($_COOKIE["panier"])) { setcookie("panier", json_encode([])); }
    if (isset($_GET["article"])) { $article = $_GET["article"]; }    

    $panier = json_decode($_COOKIE["panier"]);
    array_push($panier, $article);
    print_r($panier);

    setcookie("panier", json_encode($panier));

    // print_r(json_decode($_COOKIE["panier"]));
?>