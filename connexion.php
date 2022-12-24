<?php
session_start();

include "util.php";


if (isset($_POST["submit"])) $submit = $_POST["submit"];

if (isset($submit)) {
    if (isset($_POST["mail"])) $mail = $_POST["mail"];
    if (isset($_POST["mot_de_passe"])) $mot_de_passe = $_POST["mot_de_passe"];

    if (strlen($mail) == 0 || strlen($mail) >= 255) {
        $erreurs["mail"] = "Le champ mail est videou plus long que 255 caractères.";
    }

    if (strlen($mot_de_passe) == 0 || strlen($mot_de_passe) >= 32) {
        $erreurs["mot_de_passe_vide"] = "Le champ mot de passe est videou plus long que 32 caractères.";
    }

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
            $connectionStatement = $db->prepare("select mot_de_passe from Client where mail = :mail");
            $connectionStatement->execute([
                "mail" => $mail,
            ]);
        } catch (PDOException $e) {
            $erreurs["bdd"] = "ERREUR CRITIQUE : Une erreur est survenue lors de la connexion : " . $e->getMessage();
        }

        if ($connectionStatement->rowCount() == 0) {
            $erreurs["bdd"] = "ERREUR : Il n'y a aucun utilisateur associé à l'adresse mail spécifiée.";
        } else {
            $row = $connectionStatement->fetch(PDO::FETCH_ASSOC);

            if ($mot_de_passe == $row["mot_de_passe"]) {
                echo "Connexion réussie.";
                $_SESSION["connected"] = $mail;
            } else {
                $erreurs["bdd"] = "ERREUR : Le mot de passe spécifié est incorrect.";
            }
        }
    }

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