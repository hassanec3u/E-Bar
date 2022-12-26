<?php

$mysqli = mysqli_connect('127.0.0.1', 'root', '') or die("Erreur de connexion");

//lance une requete mysqli,
function requete($link, $requete)
{
    $resultat = mysqli_query($link, $requete);
    if (!$resultat) {
        printf("Message d'erreur : %s\n", mysqli_error($link));
        die();
    } else {
        return ($resultat);
    }
}

//creation de la base Utilisateur;
$nom_de_la_base = "Utilisateurs";
$Sql = "
		CREATE DATABASE IF NOT EXISTS $nom_de_la_base;
		
		USE $nom_de_la_base;
		
		CREATE TABLE IF NOT EXISTS Client (
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            login VARCHAR(25) UNIQUE NOT NULL,
            mot_de_passe varchar(256) NOT NULL,
            nom varchar(25) ,
            prenom varchar(25),
            sexe varchar(1),	
            mail varchar(255),
            adresse varchar(50),
            code_postale varchar(5),
            ville varchar(25),
            numero_tel varchar(10),
            date_naissance date
        );

        CREATE TABLE IF NOT EXISTS Recette (
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            titreR varchar(256)
        );
    
        CREATE TABLE IF NOT EXISTS RecetteClient (
        idClient INT REFERENCES Client(id) ON DELETE CASCADE,
        idRecette int REFERENCES Recette(id) ON DELETE CASCADE,
        PRIMARY KEY (idClient, idRecette))";

foreach (explode(';', $Sql) as $Requete) {
    requete($mysqli, $Requete);
}

mysqli_close($mysqli);

include "insertion.php";


?>