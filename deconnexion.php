<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Deconnexion</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/base.css">
    <?php include_once "util/iconLien.php"; ?>

</head>

<?php include_once "header.php"; ?>

<body>
<section id="contenu_page">
<span class="connection_text"> Vous aviez été deconnécté</span>
</section>
</body>

<?php include_once "footer.php"; ?>

</html>

