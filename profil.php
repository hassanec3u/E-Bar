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


//on met a jour les nouvelles informations du client dans la bdd
if (isset($_POST["mettreAjour"])) {
    if (mettreAJourDonnesClient($mysqli, $_POST["nom_utilisateur"], $_POST["mot_de_passe"], $_POST["nom"], $_POST["prenom"]
        , $_POST["sexe"], $_POST["mail"], $_POST["adresse"], $_POST["code_postal"], $_POST["ville"], $_POST["numero_tel"])) {
        echo "Mise A jour reussi";
    } else {
        echo "Mise A jour echoué";

    }
}

//on les recuperes pour pouvoir les afficher plus tard
$donnesClient = recupererDonnesClient($mysqli, $_SESSION["connected"]["login"], $_SESSION["connected"]["mot_de_passe"]);
?>
<form method="post">
    <label>
        Nom utilisateur :
        <input type="text" name="nom_utilisateur" value="<?php echo $donnesClient["login"]; ?>" required>
    </label>

    <label>
        Mot de passe :
        <input type="password" name="mot_de_passe" value="<?php echo $donnesClient["mot_de_passe"]; ?>"
               required>
    </label>

    <label>
        Nom :
        <input type="text" id="nom" name="nom" value="<?php echo $donnesClient["nom"]; ?>">
    </label>

    <label>
        Prenom :
        <input type="text" name="prenom" value="<?php echo $donnesClient["prenom"]; ?>">
    </label>

    <label>
        Sexe :
        <input type="text" name="sexe" value="<?php echo $donnesClient["sexe"]; ?>">
    </label>

    <label>
        Mail :
        <input type="email" name="mail" value="<?php echo $donnesClient["mail"]; ?>">
    </label>

    <label>
        Adresse :
        <input type="text" name="adresse" value="<?php echo $donnesClient["adresse"]; ?>">
    </label>

    <label>
        Code postal :
        <input type="text" name="code_postal" value="<?php echo $donnesClient["code_postale"]; ?>">
    </label>

    <label>
        Ville :
        <input type="text" name="ville" value="<?php echo $donnesClient["ville"]; ?>">
    </label>

    <label>
        Numero tel :
        <input type="number" name="numero_tel" value="<?php echo $donnesClient["numero_tel"]; ?>">
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