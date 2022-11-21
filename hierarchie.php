
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

        $page_actuelle = basename($_SERVER["REQUEST_URI"]);
        $page_actuelle = urldecode($page_actuelle);
  
        $routes = explode("/", $_SERVER["REQUEST_URI"]);

        foreach($routes as $i => $route) {
            if ($route != basename(__FILE__) && $route != "") {
                $n = count($routes) - $i - 2;
                $href = "";

                for ($x = 0; $x < $n; $x++) {
                    $href .= "../";
                }
                
                echo "<a href=\"$href\">" . urldecode($route) . "</a> / ";
            }
        }

        // if (isset($_GET["aliment"])) $aliment_utilisateur = $_GET["aliment"]; 
        if ($page_actuelle != basename(__FILE__)) $aliment_utilisateur = $page_actuelle; 
        // si le paramètre "aliment" est spécifié dans l'url, on attribut sa valeur a la variable "$aliment_utilisateur"

        $aliment = "Aliment"; // l'aliment par défaut est la racine
        $super_categorie = null;
        $sous_categorie = $Hierarchie["Aliment"]["sous-categorie"]; // la sous catégorie par défaut est la sous catégorie de la racine

        $aliment_existe = false;
        if (isset($aliment_utilisateur)) {
            // dans le cas ou la variable aliment_utilisateur on définie, on vérifie si l'aliment existe dans la hiérarchie
            foreach($Hierarchie as $nom_aliment => $categories) {
                if ($aliment_utilisateur == $nom_aliment) {
                    $aliment = $nom_aliment;
                    $aliment_existe = true;
                    $super_categorie = $categories["super-categorie"];
                    $sous_categorie = $categories["sous-categorie"];
                }
            }
        } else {
            // si la  variable n'est pas définie, on prend la racine comme aliment
            $aliment_existe = true; 
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
                    <li><a href="<?php echo "../../$nom_aliment/"; ?>"><?php echo $nom_aliment; ?></a></li>
                <?php } ?>
            <?php } ?>
                
            <?php if ($sous_categorie != null) { // on affiche les sous catégories seulement si l'aliment n'est pas une feuille ?>
                <p>sous categorie</p>

                <?php foreach($sous_categorie as $identifiant => $nom_aliment) { ?>
                    <li><a href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . $nom_aliment . "/"; ?>"><?php echo $nom_aliment; ?></a></li>
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
