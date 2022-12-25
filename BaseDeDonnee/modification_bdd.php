<?php




function recupererDonnesClient($connect, $login, $mdp)
{
    //preparation de la requettee
    $stat = mysqli_prepare($connect, "SELECT * 
    FROM Client
    WHERE login = ? AND mot_de_passe = ?");
    mysqli_stmt_bind_param($stat, "ss", $login, $mdp);
    mysqli_stmt_execute($stat);

    //verifie le mot de passe
    mysqli_stmt_store_result($stat);
    if (mysqli_stmt_num_rows($stat) == 0) {
        return null;
    } else {
        //recupeation de la requete
        mysqli_stmt_bind_result($stat, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11);
        mysqli_stmt_fetch($stat);
        return array("id" => $r1, "login" => $r2, "mot_de_passe" => $r3, "nom" => $r4,
            "prenom" => $r5, "sexe" => $r6, "mail" => $r7, "adresse" => $r8, "code_postale" => $r9, "ville" => $r10, "numero_tel" => $r11);
    }
}

//permet d'incrire un nouveau Client
function ajouterClient($connect, $login, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    $stat = mysqli_prepare($connect, "INSERT INTO Client VALUES (NULL,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stat, "ssssssssss", $login, $mot_de_passe, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel);
    $aReussi = mysqli_stmt_execute($stat);

    if (!$aReussi) {
        echo("Impossible d'ajouter un client: " . mysqli_error($connect));
    }

}


function verifierSiLoginExiste($connect, $login)
{
    $stat = mysqli_prepare($connect, "SELECT * 
    FROM Client
    WHERE login = ?");
    mysqli_stmt_bind_param($stat, "s", $login);
    mysqli_stmt_execute($stat);
    mysqli_stmt_store_result($stat);
    if (mysqli_stmt_num_rows($stat) == 0) {
        return false;
    } else {
        return true;
    }
}

//mise a jour des donnés personnelles
function mettreAJourDonnesClient($connect, $login, $mdp, $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel)
{
    $stat = mysqli_prepare($connect, "UPDATE Client
SET nom =? , prenom = ?, sexe = ? ,mail = ? ,adresse = ? ,code_postale = ? ,ville = ? ,numero_tel = ?
WHERE login = ? AND mot_de_passe = ? ");
    mysqli_stmt_bind_param($stat, "ssssssssss", $nom, $prenom, $sexe, $mail, $adresse, $code_postale, $ville, $numero_tel, $login, $mdp);
    $aReussi = mysqli_stmt_execute($stat);

    if (!$aReussi) {
        echo("Impossible de mettre a jour les information du client: " . mysqli_error($connect));
    }
}



