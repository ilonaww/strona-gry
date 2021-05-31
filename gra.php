<?php
session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta chatset="utf-8">
    <title>Osadnicy - gra przeglądarkowa</title>
</head>

<body>
    <!-- wyjmowanie danych z sesji -->
    <?php
        echo "<h2><p> Witaj " . $_SESSION['user'] . '!</h2>[ <a href="logout.php">Wyloguj się</a>]</p>'; 
        echo "<h3>Twoje surowce: </h3>";
        echo "<b>Drewno: </b>" . $_SESSION['drewno'] . " | ";
        echo "<b>Kamień: </b>" . $_SESSION['kamien'] . " | ";
        echo "<b>Zboże: </b>" . $_SESSION['zboze'] . " </br>";
        echo "<b>E-mail: </b>" . $_SESSION['email'] . "</br>";
        echo "<b>Dni premium: </b>" . $_SESSION['dnipremium'] . "</br>";

        
    ?>

</body>

</html>