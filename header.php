<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    function rechercheRecette(str) {
        if (str.length === 0) {
            document.getElementById("#result").innerHTML = "";
            document.getElementById("#result").style.border = "0px";
            return;
        }

        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("#result").innerHTML = this.responseText;
                document.getElementById("#result").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "BaseDeDonnee/rechercher.php?q=" + str, true);
        xmlhttp.send(null);
    }

</script>


<header class="header">
    <nav class="nav_enTete">
        <div class="header_logo">
            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../acceil.php"> <img
                        src="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../res/logo.jpg" height="100px" width="150px"
                        alt="logo bar"></a>
        </div>

        <div class="header_information">


            <label for="barreRecherche"></label><input id="barreRecherche" type="text"
                                                       onkeyup="rechercheRecette(this.value)"
                                                       placeholder="Rechercher une recette"> <i
                    class="fa-solid fa-magnifying-glass"></i>


            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../profil.php" id="lienCompte"
               class="header_information_item"><i class="fa-solid fa-user"></i> Compte</a>

            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../panier.php" class="header_information_item"><i
                        class="fa-solid fa-cart-shopping"></i>Panier</a>

            <a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>/../hierarchie.php" class="header_information_item"><i
                        class="fa-solid fa-martini-glass-citrus"></i> Hierarchie</a>

            <div id="#result"></div>

        </div>
    </nav>
</header>



