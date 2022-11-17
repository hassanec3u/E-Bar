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
		DROP DATABASE IF EXISTS $nom_de_la_base;
		CREATE DATABASE $nom_de_la_base;
		
		USE $nom_de_la_base;
		CREATE TABLE UTILISATEUR (
		
		id INT AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) UNIQUE NOT NULL,
		mot_de_passe varchar(25) NOT NULL,
		nom varchar(25) NOT NULL,
		prenom varchar(25),
		sexe varchar(1),	
		mail varchar(30),
		adresse varchar(50),
		code_postale varchar(5),
		ville varchar(25),
		numero_tel varchar(10))";

foreach (explode(';', $Sql) as $Requete) {
    requete($mysqli, $Requete);
}

mysqli_close($mysqli);

?>