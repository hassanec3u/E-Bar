<!DOCTYPE html>
<html lang="fr">
    <head>
        <title></title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../css/header.css">
        <link rel="stylesheet" href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../css/footer.css">
        <link rel="stylesheet" href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../css/base.css">
    </head>

    <body>
        
        <?php include_once "header.php"; ?>


        <?php
        include "Donnees.inc.php";
        include "util.php";

        $filename = basename(__FILE__);
        $url = $_SERVER["REQUEST_URI"];
        $url = urldecode($url); // permet d'éviter d'avoir des %20 a la place des ' ', etc...  
        $routes = explode("/", $url);

        if (count($routes) > 1 && $routes[count($routes) - 1] != "") {
            header("Location: http://{$_SERVER['HTTP_HOST']}{$url}/"); // ajout du '/' manquant
        } 

        if ($routes[count($routes) - 1] == "") { 
            array_splice($routes, count($routes) - 1, 1); 

            if ($routes[count($routes) - 1] == $filename) { 
                header("Location: http://{$_SERVER['HTTP_HOST']}{$url}Aliment/");
            }
        } else if ($routes[count($routes) - 1] == $filename) { 
            header("Location: http://{$_SERVER['HTTP_HOST']}{$url}/Aliment/");
        }

        while ($routes[0] != $filename) {
            array_splice($routes, 0, 1);
        }

        array_splice($routes, 0, 1);

        // affichage du parcours de l'utilisateur à travers les différents aliments
        foreach($routes as $i => $route) {
            $n = count($routes) - $i - 1;
            $href = "";

            for ($x = 0; $x < $n; $x++) {
                $href .= "../";
            }
            
            echo "<a href=\"$href\">" . urldecode($route) . "</a> / ";
        }

        $aliment = $routes[count($routes) - 1];
        $super_categorie = null;
        $sous_categorie = null;
        $aliment_existe = false;
        // dans le cas ou la variable aliment_utilisateur on définie, on vérifie si l'aliment existe dans la hiérarchie
        foreach($Hierarchie as $nom_aliment => $categories) {
            if ($aliment == $nom_aliment) {
                $super_categorie = $categories["super-categorie"];
                $sous_categorie = $categories["sous-categorie"];
                $aliment_existe = true;
            }
        }
        ?>

        <?php if (!$aliment_existe) { // si l'aliment n'existe pas, on affiche un message à l'utilisateur ?>
            <?php ?>
            <p>L'aliment que vous avez spécifié n'existe pas.</p>
        <?php } else { ?>

        <div id="aliment">
            <h1><?php echo $aliment; ?></h1>
            <ul>
                
            <?php if ($super_categorie != null) { // on affiche les super catégories seulement si l'aliment n'est pas la racine ?>
                <p>super categorie</p>
                <?php foreach($super_categorie as $identifiant => $nom_aliment) { ?>
                    <li><a href="<?php echo "../"; ?>"><?php echo $nom_aliment; ?></a></li>
                <?php } ?>
            <?php } ?>
                
            <?php if ($sous_categorie != null) { // on affiche les sous catégories seulement si l'aliment n'est pas une feuille ?>
                <p>sous categorie</p>

                <?php foreach($sous_categorie as $identifiant => $nom_aliment) { ?>
                    <?php $website = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>
                    <li><a href="<?php echo $website . $nom_aliment . "/"; ?>"><?php echo $nom_aliment; ?></a></li>
                <?php } ?>
            <?php } ?>
            </ul>
        </div>
        <?php } ?>

        <div id="liste-recettes">
        <?php foreach ($Recettes as $identifant => $recette) { ?>
            <?php foreach ($recette["index"] as $ingredient) { ?>
                
                <?php if ($ingredient == $aliment) { ?> 
                    <div class="recette">
                        <h2><?php echo $recette["titre"]; ?></h2>
                        <img src="<?php echo $_SERVER["SCRIPT_NAME"] . "/../Photos/" . str_replace(" ", "_", $recette["titre"]) . ".jpg"; ?>" alt="photo recette">
                        <p>Ingredients : <?php echo $recette["ingredients"]; ?>
                        <p>Preparation : <?php echo $recette["preparation"]; ?>
                        <p><a href="">Ajouter au panier</a></p>    
                    </div>
                <?php } ?>
              
            <?php } ?> 
        <?php } ?>
        </div>

        <?php include_once "footer.php"; ?>

        <script>
            let recettes = <?php echo json_encode($Recettes); ?>;
        </script>


        <script>
            function ajouterArticlePanier(event) {
                event.preventDefault();
                let titre = event.target.parentNode.parentNode.querySelector("h2");

                let recette = {
                    id: 0,
                    titre: "",
                }

                recettes.forEach((v, k) => {
                    if (v.titre == titre.innerHTML) {
                        recette.id = k;
                        recette.titre = v.titre;
                    }
                });

                console.log(`/<?php echo basename(__DIR__); ?>/panier.php?article=${recette.titre}&id=${recette.id}`);

                fetch(`/<?php echo basename(__DIR__); ?>/panier.php?article=${recette.titre}&id=${recette.id}`, {
                    method: "GET",
                });
                
                console.log("request sent!");
            }

            let boutonAjoutPanier = document.querySelectorAll(".recette a");

            for (i = 0; i < boutonAjoutPanier.length; i++) {
                boutonAjoutPanier[i].addEventListener("click", ajouterArticlePanier);
            }
        </script>


    </body>
</html>

<?php
    // afficher_tableau($Recettes);
?>
