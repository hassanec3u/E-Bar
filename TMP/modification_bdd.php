<?php

$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'Utilisateurs') or die("Erreur de connexion");

// fonction qui
function requete($link, $requete)
{
    $resultat = mysqli_query($link, $requete);
    if (!$resultat) {
        printf("Message d'erreur : %s\n", mysqli_error($link));
        die();
    } else {
        return $resultat;
    }
}

//permet de recuper les info d'un utilisateur
function recupererInformation($login,$mdp){
    global $mysqli;

    $sql= "SELECT * 
    FROM UTILISATEUR
    WHERE login = '$login' AND mot_de_passe = '$mdp'";

    requete($mysqli, $sql);
}

//permet d'incrire un nouveau utilisateur
function inscrire($login, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    global $mysqli;
    $sql = "INSERT INTO UTILISATEUR VALUES (NULL,'$login','$mot_de_passe','$nom','$prenom','$sexe','$mail','$adresse','$code_postale','$ville','$numero_tel')";
    requete($mysqli, $sql);
}

//mise a jour des donnés personnelles
function mettreAjourDonnees($login, $mdp, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    global $mysqli;
    $sql = "UPDATE UTILISATEUR
SET nom = '$nom', prenom = '$prenom', sexe = '$sexe' ,mail = '$mail' ,adresse = '$adresse' ,code_postale = '$code_postale' ,ville = '$ville',numero_tel = '$numero_tel'
WHERE login = '$login' AND mot_de_passe = '$mdp'";

    requete($mysqli, $sql);

}

inscrire("abouKore", "abcdef", "Kore", "Aboubacar", "H", "xxx@gmail.com", "rue bazin", "54000", "nancy", "455555550");
$res = recupererInformation('abouKore','abcdef');

//mettreAjourDonnees('$login', 'abcdef', "Kore2", "Aboubacar2", "H", "sdfs", "sdf", "sfd", "df", "dfsq");


mysqli_close($mysqli);

?>