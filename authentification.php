<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Deconnection</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/base.css">
    <?php include_once "util/iconLien.php"; ?>

</head>

<?php include_once "header.php"; ?>

<body>

<span class="connection_text">Veuillez vous connecter ou vous inscrire</span>

<input type="button" name="connexion" value="Connexion" onclick="window.location.href='connexion.php';"/>
<input type="button" name="inscription" value="Inscription" onclick="window.location.href='inscription.php';">
</body>

<?php  include "footer.php"; ?>

</html>
