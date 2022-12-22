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
    if (isset($_POST["submit"])) $submit = $_POST["submit"];

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

        // test longueur

        if (strlen($nom_utilisateur) == 0 || strlen($nom_utilisateur) >= 32) {
            $erreurs["nom_utilisateur_vide"] = "Le champ nom d'utilisateur est vide ou plus long que 32 caractères.";
        }

        if (strlen($mot_de_passe) == 0 || strlen($mot_de_passe) >= 32) {
            $erreurs["mot_de_passe_vide"] = "Le champ mot de passe est videou plus long que 32 caractères.";
        }

        if (strlen($nom) == 0 || strlen($nom) >= 32) {
            $erreurs["nom"] = "Le champ nom est vide ou plus long que 32 caractères.";
        }

        if (strlen($prenom) == 0 || strlen($prenom) >= 32) {
            $erreurs["prenom"] = "Le champ prenom est vide ou plus long que 32 caractères.";
        }

        if (strlen($sexe) == 0 || strlen($sexe) >= 2) {
            $erreurs["sexe"] = "Le champ sexe est vide ou plus long que 1 caractère.";
        }

        if (strlen($mail) == 0 || strlen($mail) >= 255) {
            $erreurs["mail"] = "Le champ mail est videou plus long que 255 caractères.";
        }

        if (strlen($adresse) == 0 || strlen($adresse) >= 32) {
            $erreurs["adresse"] = "Le champ adresse est vide ou plus long que 32 caractères.";
        }

        if (strlen($code_postal) == 0 || strlen($code_postal) >= 32) {
            $erreurs["code_postal"] = "Le champ code_postal est vide ou plus long que 32 caractères.";
        }

        if (strlen($ville) == 0 || strlen($ville) >= 32) {
            $erreurs["ville"] = "Le champ ville est vide ou plus long que 32 caractères.";
        }

        if (strlen($numero_tel) == 0 || strlen($numero_tel) >= 10) {
            $erreurs["numero_tel"] = "Le champ numero_tel est vide ou plus long que 10 caractères.";
        }

        // test longueur
        if (!isset($erreurs)) {

            try {
                $db = new PDO(
                    "mysql:host=localhost;dbname=Utilisateurs;utf8",
                    "root",
                    ""
                );
            } catch (PDOException $e) {
                $erreurs["bdd"] = "ERREUR CRITIQUE : Une erreur est survenue lors de la connection à la base de données : " . $e->getMessage();
            }
            
            try {
                $inscriptionStatement = $db->prepare("insert into Client (login, mot_de_passe, nom, prenom, sexe, mail, adresse, code_postale, ville, numero_tel) values (:login, :mot_de_passe, :nom, :prenom, :sexe, :mail, :adresse, :code_postale, :ville, :numero_tel)");
                $inscriptionStatement->execute([
                    "login" => $nom_utilisateur,
                    "mot_de_passe" => $mot_de_passe,
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "sexe" => $sexe,
                    "mail" => $mail,
                    "adresse" => $adresse,
                    "code_postale" => $code_postal,
                    "ville" => $ville,
                    "numero_tel" => $numero_tel,
                ]);
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $erreurs["bdd"] = "ERREUR : Cette adresse mail est déjà utilisée.";
                } else {
                    $erreurs["bdd"] = "ERREUR CRITIQUE : Une erreur est survenue lors de l'inscription : " . $e->getMessage();
                }
            }
        }
    }

    if (isset($erreurs)) {
        foreach($erreurs as $erreur) {
            echo "<p class='erreur'>$erreur</p>";
        }
    }
?>

<form method="post" action="inscription.php">
    <label> 
        Nom utilisateur : 
        <input 
            type="text"
            name="nom_utilisateur"
            value="<?php echo $nom_utilisateur; ?>">
    </label>

    <label>
        Mot de passe : 
        <input 
            type="password"
            name="mot_de_passe"
            value="<?php echo $mot_de_passe; ?>">
    </label>

    <label>
        Nom : 
        <input 
            type="text"
            name="nom"
            value="<?php echo $nom; ?>">
    </label>

    <label>
        Prenom : 
        <input 
            type="text"
            name="prenom"
            value="<?php echo $prenom; ?>">
    </label>

    <label>
        Sexe : 
        <input 
            type="text"
            name="sexe"
            value="<?php echo $sexe; ?>">
    </label>

    <label>
        Mail : 
        <input 
            type="mail"
            name="mail"
            value="<?php echo $mail; ?>">
    </label>

    <label>
        Adresse : 
        <input 
            type="text"
            name="adresse"
            value="<?php echo $adresse; ?>">
    </label>

    <label>
        Code postal : 
        <input 
            type="text"
            name="code_postal"
            value="<?php echo $code_postal; ?>">
    </label>

    <label>
        Ville : 
        <input 
            type="text"
            name="ville"
            value="<?php echo $ville; ?>">
    </label>

    <label>
        Numero tel : 
        <input 
            type="phone"
            name="numero_tel"
            value="<?php echo $numero_tel; ?>">
    </label>

    <input
        type="submit"
        name="submit"
        value="submit">
</form>