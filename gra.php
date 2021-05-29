<?php
session_start();
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
        echo "<p> Witaj " . $_SESSION['user'] . '![ <a href="logout.php">Wyloguj się</a>]</p>' ; 
        echo "<b>Drewno: </b>" . $_SESSION['drewno'] . " | ";
        echo "<b>Kamień: </b>" . $_SESSION['kamien'] . " | ";
        echo "<b>Zboże: </b>" . $_SESSION['zboze'] . " </ br>";
        echo "<b>E-mail: </b>" . $_SESSION['email'] . "</br>";

    ?>

</body>

</html>