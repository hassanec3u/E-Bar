<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#barreRecherche').keyup(function () {
            var recette = $(this).val();

            if (recette != "") {
                $.ajax({
                    type: 'GET',
                    url: 'BaseDeDonnee/rechercher.php',
                    data: 'rec=' + encodeURIComponent(recette),
                    success: function (data) {

                        document.getElementById("#result").innerHTML = "resultat: " + data;
                    }
                });
            }
        });
    });
</script>


<header class="header">
    <h1>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH</h1>
    <nav class="nav_enTete">
        <div class="header_logo">
            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../acceil.php"> <img src="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../res/logo.jpg" height="100px" width="150px" alt="logo bar"></a>
        </div>
        <div class="header_information">


            <label for="barreRecherche"></label><input id="barreRecherche" type="text"
                                                       placeholder="Rechercher une recette"><i
                    class="fa-solid fa-magnifying-glass"></i>


            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../profil.php" onclick=redirection() id="lienCompte" class="header_information_item"><i
                        class="fa-solid fa-user"></i> Compte</a>
            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../panier.php" class="header_information_item"><i class="fa-solid fa-cart-shopping"></i>
                Panier</a>
            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../hierarchie.php" class="header_information_item"><i
                        class="fa-solid fa-martini-glass-citrus"></i> Hierarchie</a>

        </div>
    </nav>
</header>



