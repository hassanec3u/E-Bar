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
        return false;
    }else{
        return true;
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
    mysqli_stmt_execute($stat);
    if (mysqli_affected_rows($connect) >0 ) {
        return true;
    }
}

function ajouterRecette($connect, $id, $titreR) {
    $stmt = mysqli_prepare($connect, "insert into Recette (titreR) values (?)");
    $stmt->bind_param("s", $titreR);
    $stmt->execute();
}

function ajouterRecetteClient($connect, $idclient, $idRecette) {
    $stmt = mysqli_prepare($connect, "insert into RecetteClient (idClient, idRecette) values (?, ?)");
    $stmt->bind_param("ss", $idclient, $idRecette);
    $stmt->execute();
}

function viderRecettesClient($connect, $idClient) {
    $stmt = mysqli_prepare($connect, "delete from RecetteClient where idClient = ?");
    $stmt->bind_param("s", $idClient);
    $stmt->execute();

    echo "vide";
}

function recupererPanier($connect, $idClient) {
    $stmt = mysqli_prepare($connect, "select * from RecetteClient rc, Recette r where rc.idClient = ? and rc.idRecette = r.id");
    $stmt->bind_param("s", $idClient);
    /* execute statement */
    $stmt->execute();
    $result = $stmt->get_result(); # all rows to array

    $res = [];
    $i = 0;

    while ($data = $result->fetch_assoc())
    {
        $res[$i] = $data;
        $i += 1;
    }
    

    return $res;
    return false;
}

function rechercher($connect, $recherche) {
    $recherche = "$recherche%";
    $stmt = mysqli_prepare($connect, 'select * from Recette r where r.titreR like ? LIMIT 5');
    $stmt->bind_param("s", $recherche);
    /* execute statement */
    $stmt->execute();
    $result = $stmt->get_result(); # all rows to array

    $res = [];
    $i = 0;

    while ($data = $result->fetch_assoc())
    {
        $res[$i] = $data;
        $i += 1;
    }

    return $res;
}

//ajouterClient("abouKore", "abcdef", "Kore", "Aboubacar", "H", "xxx@gmail.com", "rue bazin", "54000", "nancy", "455555550");
//mettreAJourDonnesClient("bouKore", "abcdef", "tata", "almou", "h", "ras", "ras", "ras", "ras", "ras");

//$test = recupererDonnesClient("abouKore","abcdef");
//$res = recupererInformation('abouKore','abcdef');


