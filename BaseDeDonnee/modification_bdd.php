<?php

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

//permet de recuper les info d'un Client
function recupererDonnesClient($login, $mdp)
{
    global $mysqli;
    //preparation de la requettee
    $stat = mysqli_prepare($mysqli, "SELECT * 
    FROM Client
    WHERE login = ? AND mot_de_passe = ?");
    mysqli_stmt_bind_param($stat, "ss", $login, $mdp);
    mysqli_stmt_execute($stat);
    //recupeation de la requete
    mysqli_stmt_bind_result($stat, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11);
    mysqli_stmt_fetch($stat);

    //renvoie le resultat sous forme de table
    return array($r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11);
}

//permet d'incrire un nouveau Client
function ajouterClient($connect,$login, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    global $mysqli;
    $stat = mysqli_prepare($connect, "INSERT INTO Client VALUES (NULL,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stat, "ssssssssss", $login, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel);
    $aReussi = mysqli_stmt_execute($stat);

    if (!$aReussi) {
        echo("Impossible d'ajouter un client: " . mysqli_error($connect));
    }

}

//mise a jour des donnés personnelles
function mettreAJourDonnesClient($connect,$login, $mdp, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    global $mysqli;
    $stat = mysqli_prepare($connect, "UPDATE Client
SET nom =? , prenom = ?, sexe = ? ,mail = ? ,adresse = ? ,code_postale = ? ,ville = ? ,numero_tel = ?
WHERE login = ? AND mot_de_passe = ? ");
    mysqli_stmt_bind_param($connect, "ssssssssss", $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel, $login, $mdp);
    mysqli_stmt_execute($stat);
}








//ajouterClient("abouKore", "abcdef", "Kore", "Aboubacar", "H", "xxx@gmail.com", "rue bazin", "54000", "nancy", "455555550");
//mettreAJourDonnesClient("bouKore", "abcdef", "tata", "almou", "h", "ras", "ras", "ras", "ras", "ras");

//$test = recupererDonnesClient("abouKore","abcdef");
//$res = recupererInformation('abouKore','abcdef');


