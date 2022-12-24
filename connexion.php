<?php
session_start();

//bloc php pour inclure les fonction neccesaire pour la bdd de bdd
include_once "BaseDeDonnee/modification_bdd.php";
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");


include "util.php";

$mail = "";
$mot_de_passe = "";
//verifie si le formulaire a ete soumiss
if (isset($_POST["submit"])) $submit = $_POST["submit"];

if (isset($submit)) {
    if (isset($_POST["mail"])) $mail = $_POST["mail"];
    if (isset($_POST["mot_de_passe"])) $mot_de_passe = $_POST["mot_de_passe"];

    if (strlen($mail) == 0 || strlen($mail) >= 255) {
        $erreurs["mail"] = "Le champ mail est vide ou plus long que 255 caractères.";
    }

    if (strlen($mot_de_passe) == 0 || strlen($mot_de_passe) >= 32) {
        $erreurs["mot_de_passe_vide"] = "Le champ mot de passe est vide ou plus long que 32 caractères.";
    }

    if (!isset($erreurs)) {
        if (verifierSiMailExiste($mysqli, $mail)) {

            //stocke les information du client dans un tableau
            $result = recupererDonnesClient($mysqli, $mail, $mot_de_passe);

            if (!empty($result)) {
                echo "Connexion réussie.";
                $_SESSION["connected"] = $mail;
            }
        }
    }

    //affichage des erreur
    if (isset($erreurs)) {
        foreach ($erreurs as $erreur) {
            echo "<p class='erreur'>$erreur</p>";
        }
    }
}
?>

<?php
if (isset($_SESSION["connected"])) {
    echo "<p>Connecté en temps que " . $_SESSION['connected'] . ". <a href='deconnexion.php'>Deconnexion</a></p>";
} else {
    echo "<p>Vous n'êtes pas connecté</p>";
}
?>

<form method="post" action="connexion.php">
    <label>
        Mail :
        <input
                type="email"
                name="mail"
                value="<?php echo $mail; ?>">
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