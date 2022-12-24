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
//DROP DATABASE IF EXISTS $nom_de_la_base;

//creation de la base Utilisateur;
$nom_de_la_base = "Utilisateurs";
$Sql = "
		
		CREATE DATABASE $nom_de_la_base;
		
		USE $nom_de_la_base;
		
		CREATE TABLE Client (
		id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
		login VARCHAR(25) UNIQUE NOT NULL,
		mot_de_passe varchar(25) NOT NULL,
		nom varchar(25) ,
		prenom varchar(25),
		sexe varchar(1),	
		mail varchar(255) UNIQUE,
		adresse varchar(50),
		code_postale varchar(5),
		ville varchar(25),
		numero_tel varchar(10));

    CREATE TABLE Recette (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    titreR varchar(25));
    
    CREATE TABLE RecetteClient (
    idClient INT PRIMARY KEY,
    idRecette int ,
    FOREIGN KEY (idClient) REFERENCES Recette(id) ON DELETE CASCADE,
    FOREIGN KEY (idRecette) REFERENCES Client(id) ON DELETE CASCADE) ";

foreach (explode(';', $Sql) as $Requete) {
    requete($mysqli, $Requete);
}

mysqli_close($mysqli);

?>