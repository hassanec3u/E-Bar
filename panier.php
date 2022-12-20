<!DOCTYPE html>
<html>
    <head>
        <title>Panier</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo "http://" . $_SERVER["HTTP_HOST"]; ?>/styles.css">
    </head>

    <body>
        <h1>Votre panier</h1>

        <?php

        if (!isset($_COOKIE["panier"])) { 
            // si le cookie panier n'existe on le crée
            setcookie("panier", json_encode([]), 0, "/");

        } else {
            $panier = json_decode($_COOKIE["panier"]);

            if (isset($_GET["article"])) {
                // ajout d'un nouvel article dans le panier
                $article = $_GET["article"];

                if (!in_array($article, $panier)) {
                    array_push($panier, $article);
                }
                setcookie("panier", json_encode($panier));
            } else {
                // affichage du contenu du panier

                if (count($panier) == 0) {
                    echo "<p>Votre panier est vide !</p>";
                } else {
                    echo "<ul>";
                    foreach($panier as $aliment) {
                        echo "<li><span class=\"aliment\">" . $aliment . "</span> <span class=\"supprimer\">❌</span></li>";
                    }
                    echo "</ul>";
                }
            }
        }

        if (isset($_GET["supprimer"])) {
            // suppression d'un article du panier
            $supprimer = $_GET["supprimer"];
            $panier = json_decode($_COOKIE["panier"]);
            foreach ($panier as $k => $v) {
                echo "<br>";
                if ($v == $supprimer) {
                    $panier = array_splice($panier, $k+1, 1);
                }
                print_r($panier);

                setcookie("panier", json_encode($panier));
            }
        }

        ?>

        <script>
            let supprimer = document.querySelectorAll(".supprimer");

            for (i = 0; i < supprimer.length; i++) {
                supprimer[i].addEventListener("click", (e) => {
                    let aliment = e.target.parentNode.querySelector(".aliment").innerHTML;

                    fetch(`/panier.php?supprimer=${aliment}`, {
                        method: "GET",
                    });

                    console.log("suppression", aliment);
                    console.log(`/panier.php?supprimer=${aliment}`)
                });
            }
        </script>
    </body>
</html>

