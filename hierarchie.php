<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo "http://" . $_SERVER["HTTP_HOST"]; ?>/styles.css">
    </head>

    <body>
        <header>
            <h1>Accès hiérarchique aux recettes à partir de la hiérarchie des aliments</h1>
        </header>

        <?php
        include "Donnees.inc.php";
        include "util.php";

        $url = $_SERVER["REQUEST_URI"];
        $url = urldecode($url); // permet d'éviter d'avoir des %20 a la place des ' ', etc...  
        $routes = explode("/", $url);
        array_splice($routes, 0, 2); // supprime les deux premiers élément du tableau : "https://localhost:8080" et "hierarchie.php".

        $filename = basename(__FILE__);
        if (count($routes) == 0 || count($routes) == 1) { 
            header("Location: http://{$_SERVER['HTTP_HOST']}/{$filename}/Aliment/"); // redirection vers accueil hierarchie
        } else if (count($routes) > 1 && $routes[count($routes) - 1] != "") {
            header("Location: http://{$_SERVER['HTTP_HOST']}{$url}/"); // ajout du '/' manquant
        }

        if ($routes[count($routes) - 1] == "") { 
            array_splice($routes, count($routes) - 1, 1); 
        }

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
                        <h2><?php echo $recette["titre"]; ?></h1>
                        <img src="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/Photos/" . str_replace(" ", "_", $recette["titre"]) . ".jpg"; ?>">
                        <p>Ingredients : <?php echo $recette["ingredients"]; ?>
                        <p>Preparation : <?php echo $recette["preparation"]; ?>
                    </div>
                <?php } ?>
              
            <?php } ?> 
        <?php } ?>
        </div>

        <footer>

        </footer>
    </body>
</html>

<?php
    // afficher_tableau($Recettes);
?>
