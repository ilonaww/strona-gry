<?php
	session_start();
    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']== true)){
        header('Location:gra.php'); 
        exit();
    } //domyślnie najpierw przeglądarka wykona cały kod na tej stronie czego my nie chcemy. Aby temu przeciwdziałać dodajemy:
    

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Osadnicy</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>

</head>

<body>
    <div id="container" >

    <p><h2>Lepszej gry żeś jeszcze nie widział. Hyżo podonżaj za mno!</h2> </p> 
    <br>
    <a href="rejestracja.php">Rejestracja </a>
    </br> </br>

    <div class="form">
    <form action="zaloguj.php" method="post">
    Login: </br><input type="text" name="login"></br>
    Hasło: </br><input type="password" name="haslo"></br>
    <input type="submit" value="Zaloguj się"> 
    </form>
    </div>
 

    <?php

        if(isset($_SESSION['blad']))
        {
            echo $_SESSION['blad'];
        }

    ?>

    </div>
</body>

</html>