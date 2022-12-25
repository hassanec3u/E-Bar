<!DOCTYPE html>
<html>
    <head>
        <title>Panier</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/base.css">
        <?php // include_once "util/iconLien.php"; ?>
    </head>

    <body>
        <?php include_once "header.php"; ?>

        <h1>Votre panier</h1>

        <?php
        include_once "BaseDeDonnee/modification_bdd.php";
        session_start();

        if (!isset($_COOKIE["panier"])) { 
            // si le cookie panier n'existe on le crée
            setcookie("panier", json_encode([]), 0, "/");

        } else {
            $panier = json_decode($_COOKIE["panier"], true);

            if (isset($_GET["article"])) {
                // ajout d'un nouvel article dans le panier
                $article = $_GET["article"];
                $id = $_GET["id"];

                print_r($panier);
                echo $id . " " . $article;
                $panier[$id] = $article;


                if (isset($_SESSION["connected"])) {
                    $mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

                    try {
                        viderRecettesClient($mysqli, $_SESSION["connected"]["id"]);
                    } catch (Exception $e) {

                    }

                    foreach($panier as $id => $recette) {
                        try {
                            ajouterRecetteClient($mysqli, $_SESSION["connected"]["id"], ((int) ($id)) + 1);
                        } catch(Exception $e) {

                        }
                    }

                    $mysqli->close();
                }
               
                setcookie("panier", json_encode($panier));
            } else {
                // affichage du contenu du panier
                if (isset($_SESSION["connected"])) {
                    $mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");
                    $panierSql = recupererPanier($mysqli, $_SESSION["connected"]["id"]);

                    echo "<ul>";
                    foreach($panierSql as $x) {
                        echo "<li><span class=\"aliment\">" . $x["titreR"] . "</span> <span class=\"supprimer\">❌</span></li>";
                    } 
                    echo "</ul>";

                    $mysqli->close();
                } else {
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
        }

        if (isset($_GET["supprimer"])) {
            // suppression d'un article du panier
            $supprimer = $_GET["supprimer"];
            $panier = json_decode($_COOKIE["panier"], true);

            foreach ($panier as $k => $v) {
                if ($v == $supprimer) {
                    unset($panier[$k]);
                }
            }

            print_r($panier);

            if (isset($_SESSION["connected"])) {
                $mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");
                try {
                    echo "suppression bdd";

                    echo $_SESSION["connected"]["id"];
                    viderRecettesClient($mysqli, $_SESSION["connected"]["id"]);
                    echo $_SESSION["connected"]["id"];

                } catch (Exception $e) {
                    echo "$e";
                }

                foreach($panier as $id => $recette) {
                    try {
                        ajouterRecetteClient($mysqli, $_SESSION["connected"]["id"], ((int) ($id)) + 1);
                    } catch(Exception $e) {
                        echo "$e";

                    }
                }

                $mysqli->close();
            }

            setcookie("panier", json_encode($panier));

        }

        ?>

        <?php include_once "footer.php"; ?>


        <script>
            let supprimer = document.querySelectorAll(".supprimer");

            for (i = 0; i < supprimer.length; i++) {
                supprimer[i].addEventListener("click", (e) => {
                    let aliment = e.target.parentNode.querySelector(".aliment").innerHTML;

                    fetch(`/<?php echo basename(__DIR__); ?>/panier.php?supprimer=${aliment}`, {
                        method: "GET",
                    });

                    console.log("suppression", aliment);
                    console.log(`ecole/panier.php?supprimer=${aliment}`)
                });
            }
        </script>
    </body>
</html>

