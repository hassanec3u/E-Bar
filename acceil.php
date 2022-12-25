<?php
session_start();

//contien le lien ou on sera rediriger en cas de click sur "mon profil"
$lienRedirection = '';
if(isset($_SESSION["connected"]) ){
    $lienRedirection="profil.php";
}else{
    $lienRedirection="authentification.php";
}
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <title>Bienvenue sur StreetBar</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/base.css">
    <?php include_once "util/iconLien.php"?>
<script>
function redirection(){
    document.getElementById("lienCompte").href =<?php echo json_encode($lienRedirection )?>
}
</script>
</head>

<?php include_once "header.php"?>

<body>

</body>

<?php include_once "footer.php"?>


</html>