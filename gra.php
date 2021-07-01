<?php
session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta chatset="utf-8">
    <title>Osadnicy - gra przeglądarkowa</title>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
    <!-- wyjmowanie danych z sesji -->
    <div id="container">
    <div class="form">
    <?php
        echo "<h2><p> Witaj " . $_SESSION['user'] . '!</h2>[<a href="logout.php">Wyloguj się</a>]</p>'; 
        echo "<h3>Twoje surowce: </h3>";
        echo "<b>Drewno: </b>" . $_SESSION['drewno'] . " | ";
        echo "<b>Kamień: </b>" . $_SESSION['kamien'] . " | ";
        echo "<b>Zboże: </b>" . $_SESSION['zboze'] . " </br>";
        echo "<b>E-mail: </b>" . $_SESSION['email'] . "</br>";
        echo "<b>Data wygaśnięcia premium: </b>" . $_SESSION['dnipremium'] . "</br>";

        $dataczas = new DateTime('2150-05-01 09:33:59');
         
       // uzycie operatora zasięgu
       $koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']); 
       
       $roznica = $dataczas->diff($koniec);

       //sprawdzenie czy aktualna data i czas jest wcześniejsza od daty i czasu wygaśnięcia usługi

       if($dataczas<$koniec)
       {
       echo "<b>Pozostało premium:</b> " . $roznica->format('%d dni, %h godzin, %m minut');
       }
       else
       {
       echo "<b>Premium nie aktywne od: </b>" . $roznica->format('%d dni, %h godzin, %m minut');
       }
    ?>
    </div>
</div>
</body>

</html>