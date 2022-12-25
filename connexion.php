<?php
session_start();

//bloc php pour inclure les fonction neccesaire pour la bdd de bdd
include_once "BaseDeDonnee/modification_bdd.php";
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

include "util.php";

$login = "";
$mot_de_passe = "";
//verifie si le formulaire a ete soumiss
if (isset($_POST["submit"])) $submit = $_POST["submit"];

if (isset($submit)) {
    if (isset($_POST["login"])) $login = $_POST["login"];
    if (isset($_POST["mot_de_passe"])) $mot_de_passe = $_POST["mot_de_passe"];

    if (strlen($login) == 0 || strlen($login) >= 25) {
        $erreurs["login"] = "Le champ login est vide ou plus long que 25 caractères.";
    }

    if (strlen($mot_de_passe) == 0 || strlen($mot_de_passe) >= 32) {
        $erreurs["mot_de_passe_vide"] = "Le champ mot de passe est vide ou plus long que 32 caractères.";
    }

    if (!isset($erreurs)) {
        if (verifierSiLoginExiste($mysqli, $login)) {

            //stocke les information du client dans un tableau
            $result = recupererDonnesClient($mysqli, $login, $mot_de_passe);

            if (!empty($result)) {
                // echo "Connexion réu ssie.";
                $_SESSION["connected"] = $result;
            }
        } else {
            $erreurs["login_incorrect"] = "ERREUR : Il n'y a aucun utilisateur associé au login spécifié";

        }

    }
}
?>

<?php
mysqli_close($mysqli);
?>


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

<?php

//affichage des erreur
if (isset($erreurs)) {
    foreach ($erreurs as $erreur) {
        echo "<p class='erreur'>$erreur</p>";
    }
}

if (isset($_SESSION["estConnecte"])) {
    echo "Connexion réussie.";

    echo "<p>Connecté en temps que " . $_SESSION['connected']['login'] . ". <a href='deconnexion.php'>Deconnexion</a></p>";
} else {
    echo "<p>Vous n'êtes pas connecté</p>";
}

?>

<form method="post" action="connexion.php">
    <label>
        Login :
        <input
                type="text"
                name="login"
                value="<?php echo $login; ?>">
    </label>

    <label>
        Mot de passe :
        <input
                type="password"
                name="mot_de_passe"
                value="<?php echo $mot_de_passe; ?>">
    </label>

    <input
            type="submit"
            name="submit"
            value="submit">
</form>
</body>

<?php include "footer.php"; ?>

</html>


