<?php
session_start();

//on redirige le clien vers la page de connection
if (!(isset($_SESSION["connected"]))) {
    header("Location: authentification.php");
    exit();
}


include_once "BaseDeDonnee/modification_bdd.php";
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");
?>
    <!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes donnes personnelles</title>
    <meta charset="utf-8"/>
    <style>
        label {
            display: block;
        }

    </style>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/base.css">

    <?php include_once "util/iconLien.php" ?>
</head>
<?php include_once "header.php" ?>
<body>
    <section id="contenu_page">
<h1>Mes informations Personnelles</h1>

<?php


if (isset($_POST["date_naissance"])) {
    if ($_POST["date_naissance"] == "") {
        $_POST["date_naissance"] = null;

    }
}

// print_r($_POST);
$mdp_hash = recupererMotDePasse($mysqli, $_SESSION["connected"]["login"]);
$donnesClient = recupererDonnesClient($mysqli, $_SESSION["connected"]["login"], $mdp_hash);

//on met a jour les nouvelles informations du client dans la bdd
if (isset($_POST["mettreAjour"])) {
    echo "<h1>" . $_POST["date_naissance"] . "</h1>";

    if (mettreAJourDonnesClient($mysqli, $_POST["nom_utilisateur"], $_POST["mot_de_passe"], $_POST["nom"], $_POST["prenom"]
        , $_POST["sexe"], $_POST["mail"], $_POST["adresse"], $_POST["code_postal"], $_POST["ville"], $_POST["numero_tel"], $_POST["date_naissance"], $_POST["ancien_login"], $_POST["ancien_mdp"])) {
        echo "Mise A jour reussi";

        $_SESSION["connected"] = recupererDonnesClient($mysqli, $_SESSION["connected"]["login"], $mdp_hash);
    } else {
        echo "Mise A jour echoué";

    }
}

//on les recuperes pour pouvoir les afficher plus tard


?>
<form method="post">
    <input type="hidden" name="ancien_login" value="<?php echo $_SESSION["connected"]["login"]; ?>">
    <input type="hidden" name="ancien_mdp" value="<?php echo $mdp_hash ?>">

    <label>
        Nom utilisateur :
        <input type="text" name="nom_utilisateur" value="">
    </label>

    <label>
        Mot de passe :
        <input type="password" name="mot_de_passe" value="">
    </label>

    <label>
        Nom :
        <input type="text" id="nom" name="nom" value="">
    </label>

    <label>
        Prenom :
        <input type="text" name="prenom" value="">
    </label>

    <label>
        Sexe :
        <input type="text" name="sexe" value="">
    </label>

    <label>
        Mail :
        <input type="email" name="mail" value="">
    </label>

    <label>
        Adresse :
        <input type="text" name="adresse" value="">
    </label>

    <label>
        Code postal :
        <input type="text" name="code_postal" value="">
    </label>

    <label>
        Ville :
        <input type="text" name="ville" value="">
    </label>

    <label>
        Numero tel :
        <input type="number" name="numero_tel" value="">
    </label>

    <label>
        Date de naissance :
        <input
                type="date"
                name="date_naissance"
                value="<?php echo htmlentities($date_naissance); ?>">
    </label>

    <input type="submit" id="mettreAjour" name="mettreAjour" value="Mettre A jour">
    <input type="button" name="deconnection" value="Deconnection"
           onclick="window.location.href='deconnexion.php'">
</form>

</section>
</body>
<?php include_once "footer.php" ?>
</html>

<?php

mysqli_close($mysqli);
?>