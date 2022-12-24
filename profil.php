<?php

session_start();
include_once "BaseDeDonnee/modification_bdd.php";
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

?>

<h1>Mes informations Personnelles</h1>
<?php
$donnesClient = recupererDonnesClient($mysqli, $_SESSION["login"], $_SESSION["mot_de_passe"]);

mysqli_close($mysqli);
?>


<form method="post" action="inscription.php">
    <label>
        Nom utilisateur :
        <input type="text" name="nom_utilisateur" value="<?php echo $donnesClient["login"]; ?>" required>
    </label>

    <label>
        Mot de passe :
        <input type="password" name="mot_de_passe" value="<?php echo $donnesClient["mot_de_passe"]; ?>" required>
    </label>

    <label>
        Nom :
        <input type="text" name="nom" value="<?php echo $donnesClient["nom"]; ?>">
    </label>

    <label>
        Prenom :
        <input type="text"
               name="prenom" value="<?php echo $donnesClient["prenom"]; ?>">
    </label>

    <label>
        Sexe :
        <input type="text"
                name="sexe" value="<?php echo $donnesClient["sexe"]; ?>">
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

    <input type="button" name="mettreAjour" value="Mettre A jour" onclick="">
    <input type="button" name="deconnection" value="Deconnection" onclick="window.location.href='deconnexion.php'">

</form>
