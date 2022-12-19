<?php

if (!isset($_COOKIE["panier"])) {
    setcookie("panier", json_encode([]), 0, "/");

} else {
    $panier = json_decode($_COOKIE["panier"]);
    if (isset($_GET["article"])) {
        $article = $_GET["article"];

        if (!in_array($article, $panier)) {
            array_push($panier, $article);
        }
        setcookie("panier", json_encode($panier));
    } else {
        echo "<ul>";
        foreach($panier as $aliment) {
            echo "<li><span class=\"aliment\">" . $aliment . "</span> <span class=\"supprimer\">❌</span></li>";
        }
        echo "</ul>";
    }
}

if (isset($_GET["supprimer"])) {
    $supprimer = $_GET["supprimer"];
    $panier = json_decode($_COOKIE["panier"]);
    foreach ($panier as $k => $v) {
        print_r($panier); 
        echo "<br>";
        if ($v == $supprimer) {
            echo $k . " => " . $v . " == "  . $supprimer . "<br>";

            $panier = array_splice($panier, $k+1, 1);
        }
        print_r($panier);

        setcookie("panier", json_encode($panier));
    }
}

?>