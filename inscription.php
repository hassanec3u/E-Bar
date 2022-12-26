<style>
    label {
        display: block;
    }

    .erreur {
        color: red;
        font-weight: 900;
    }
</style>
<?php
//bloc php pour inclure les fonction neccesaire pour la bdd de bdd
include_once "BaseDeDonnee/modification_bdd.php";
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

?>
<?php
$nom_utilisateur = "";
$mot_de_passe = "";
$nom = "";
$prenom = "";
$sexe = "";
$mail = "";
$adresse = "";
$code_postal = "";
$ville = "";
$numero_tel = "";
$date_naissance = "";

//verifie si le formulaire   ete validé
if (isset($_POST["submit"])) $submit = $_POST["submit"];

//verrification des champs
if (isset($submit)) {
    if (isset($_POST["nom_utilisateur"])) $nom_utilisateur = $_POST["nom_utilisateur"];
    if (isset($_POST["mot_de_passe"])) $mot_de_passe = $_POST["mot_de_passe"];
    if (isset($_POST["nom"])) $nom = $_POST["nom"];
    if (isset($_POST["prenom"])) $prenom = $_POST["prenom"];
    if (isset($_POST["sexe"])) $sexe = $_POST["sexe"];
    if (isset($_POST["mail"])) $mail = $_POST["mail"];
    if (isset($_POST["adresse"])) $adresse = $_POST["adresse"];
    if (isset($_POST["code_postal"])) $code_postal = $_POST["code_postal"];
    if (isset($_POST["ville"])) $ville = $_POST["ville"];
    if (isset($_POST["numero_tel"])) $numero_tel = $_POST["numero_tel"];
    if (isset($_POST["date_naissance"])) $date_naissance = $_POST["date_naissance"];


    // test longueur des champs du formulaire
    if (strlen($nom_utilisateur) == 0 || strlen($nom_utilisateur) >= 32) {
        $erreurs["nom_utilisateur_vide"] = "Le champ nom d'utilisateur est vide ou plus long que 25 caractères.";
    }

    if (strlen($mot_de_passe) == 0 || strlen($mot_de_passe) >= 32) {
        $erreurs["mot_de_passe_vide"] = "Le champ mot de passe est videou plus long que 25 caractères.";
    }

    if (strlen($nom) >= 32) {
        $erreurs["nom"] = "Le champ nom est plus long que 25 caractères.";
    }

    if (strlen($prenom) >= 32) {
        $erreurs["prenom"] = "Le champ prenom est plus long que 25 caractères.";
    }

    if (strlen($sexe) >= 2) {
        $erreurs["sexe"] = "Le champ sexe est vide ou plus long que 1 caractère.";
    }

    if (strlen($mail) >= 255) {
        $erreurs["mail"] = "Le champ mail est vide ou plus long que 64 caractères.";
    }

    if (strlen($adresse) >= 32) {
        $erreurs["adresse"] = "Le champ adresse est plus long que 50 caractères.";
    }

    if (strlen($code_postal) >= 32) {
        $erreurs["code_postal"] = "Le champ code_postal est vide ou plus long que 5 caractères.";
    }

    if (strlen($ville) >= 32) {
        $erreurs["ville"] = "Le champ ville est vide ou plus long que 25 caractères.";
    }

    if (strlen($numero_tel) > 10) {
        $erreurs["ville"] = "Le champ numero_tel est vide ou plus long que 10 caractères.";
    }

    if ($date_naissance == "") {
        $date_naissance = null;
    }

    

    // test longueur
    if (!isset($erreurs)) {
        //ajout de client dans la bdd
        if (!ajouterClient($mysqli, $nom_utilisateur, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postal, $ville, $numero_tel, $date_naissance)) {
            $erreurs["numero_tel"] = "Impossible d'ajouter un client: Login deja utilisé" ;
        } else {
            $inscriptionReussie = true;
        }

    }
}

mysqli_close($mysqli); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>S'inscrire</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/base.css">
    <?php include_once "util/iconLien.php"; ?>

</head>
<?php include_once "header.php"; ?>
<body>
<section id="contenu_page">
<?php
if (isset($erreurs)) {
    foreach ($erreurs as $erreur) {
        echo "<p class='erreur'>$erreur</p>";
    }
}
?>

<?php 
if (isset($inscriptionReussie)) {
    echo "<h1>Inscription réussie</h1>";
} else {
?>


<form method="post" action="inscription.php">
    <label>
        Nom utilisateur :
        <input
                type="text"
                name="nom_utilisateur"
                value="<?php echo htmlentities($nom_utilisateur); ?>"
                required>
    </label>

    <label>
        Mot de passe :
        <input
                type="password"
                name="mot_de_passe"
                value="<?php echo htmlentities($mot_de_passe); ?>"
                required>
    </label>

    <label>
        Nom :
        <input
                type="text"
                name="nom"
                value="<?php echo htmlentities($nom); ?>">
    </label>

    <label>
        Prenom :
        <input
                type="text"
                name="prenom"
                value="<?php echo htmlentities($prenom); ?>">
    </label>

    <fieldset>
        <legend>Sexe : </legend>
        <div>
            <input type="radio" name="sexe" value="h">
            <label>Homme</label>
        </div>

        <div>
            <input type="radio" name="sexe" value="f">
            <label>Femme</label>
        </div>

    </fieldset>

    

    <label>
        Mail :
        <input
                type="email"
                name="mail"
                value="<?php echo htmlentities($mail); ?>">
    </label>

    <label>
        Adresse :
        <input
                type="text"
                name="adresse"
                value="<?php echo htmlentities($adresse); ?>">
    </label>

    <label>
        Code postal :
        <input
                type="text"
                name="code_postal"
                value="<?php echo htmlentities($code_postal); ?>">
    </label>

    <label>
        Ville :
        <input
                type="text"
                name="ville"
                value="<?php echo htmlentities($ville); ?>">
    </label>

    <label>
        Numero tel :
        <input
                type="number"
                name="numero_tel"
                value="<?php echo htmlentities($numero_tel); ?>">
    </label>

    <label>
        Date de naissance :
        <input
                type="date"
                name="date_naissance"
                value="<?php echo htmlentities($date_naissance); ?>">
    </label>

    <input
            type="submit"
            name="submit"
            value="submit">
</form>
<?php
}
?>
</section>
</body>

<?php include_once "footer.php"; ?>

</html>


