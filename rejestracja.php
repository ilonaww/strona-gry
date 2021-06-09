
<?php
    session_start();
    //sprawdzenie czy taka zmienna istnieje, jeśli tak oznacza to, że formularz rejestracji został już wysłany
    if(isset($_POST['nick'])){
        //udana walidacja
        $wszystko_ok = true;
        //sprawdzenie poprawności nick
        $nick = $_POST['nick'];
        //sprawdzenie czy w zostało cokolwiek wpisane w formularz
        //sprawdzenie długości łańcucha
        if((strlen($nick)<3) || (strlen($nick)>20))
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków.";
        }
 
        if(ctype_alnum($nick) == false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] = "Nick może składać się z tylko liter i cyfr.";
        }

        //sprawdzenie poprawności adresu email 
        $email = $_POST['email'];
        $email_ok = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($email_ok, FILTER_VALIDATE_EMAIL)==false) || ($email_ok!=$email))
        {
            $wszystko_ok = false;
            $_SESSION['e_email'] = "Podaj poprawny adres e-mail.";
        }

        //sprawdzenie poprawności hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków.";
        }

        if($haslo1 != $haslo2)
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = "Podane hasła nie są identyczne.";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        //czy zakceptowano regulamin
        if(!isset($_POST['regulamin']))
         {
            $wszystko_ok = false;
            $_SESSION['e_regulamin'] = "Nie zaakceptowano regulaminu.";
         }

         //sprawdzenie czy uzytkownik to robot
         $sekret = "6LcEhgUbAAAAAJYzycrM5MTQvAim9uNsmeHotE4c";
         $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

         $odpowiedz= json_decode($sprawdz);
         if($odpowiedz->success==false)
         {
            $wszystko_ok = false;
            $_SESSION['e_bot'] = "Potwierdź że nie jesteś botem.";
         }

         require_once('connect.php');

         //ustawienie sposobu raportowania błędów, które od teraz ma być oparte o wyjątki a nie o ostrzeżenia 
         mysqli_report(MYSQLI_REPORT_STRICT);
         try
          {
            $polaczenie = new mysqli($host,$db_user,$db_password, $db_name);

            if($polaczenie->connect_errno != 0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else //połączenie sie udało
            {
                //sprawdzenie czy email już istnieje
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_maili = $rezultat->num_rows;
                if($ile_maili > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email";
                }
                     //sprawdzenie czy nick już istnieje
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_nickow = $rezultat->num_rows;
                if($ile_nickow > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_nick'] = "Istnieje już gracz o takim nicku. Wybierz inny.";
                }

                if($wszystko_ok == true)
                {
                    //Testy zaliczone
                   
                    exit();
                }

                $polaczenie->close();
            }
         }
            catch(Exception $e)
         {
             echo '<span style="color:red">Błąd serwera. Posimy o rejestracje w innym terminie</span>';
             echo '</br> Informacja developerska' . $e;
         }

  
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <header>
        <meta charset="utf-8">
        <title>Rejsetracja</title>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                margin-bottom: 10px;
            }

        </style>
    <header>

    <body>

        <h2>Zarejestruj się za darmo już dziś!</h2>
        <form method="post">
            Nick: </br> <input name="nick" type="text"> </br>
            <?php
                if(isset($_SESSION['e_nick']))
                {
                    echo'<div class="error">' . $_SESSION['e_nick'] . "</div>";
                    //nalezy wyczyścić tą zmienną sesyjną, inaczej błąd będzie się pojawiał nawet przy prawidłowym woisaniu nicku
                    unset($_SESSION['e_nick']);
                }
            ?>
            E-mail: </br> <input name="email" type="text"> </br>

                <?php
                    if(isset($_SESSION['e_email']))
                    {
                        echo '<div class="error" >' . $_SESSION['e_email'] . '</div>';
                        unset($_SESSION['e_email']);
                    }
                ?>
            Hasło: </br> <input name="haslo1" type="password"> </br>

            <?php
                if(isset($_SESSION['e_haslo']))
                {
                    echo '<div class = "error">' . $_SESSION['e_haslo'] . '</div>';
                    unset($_SESSION['e_haslo']);
                }
            ?>
            Powtórz Hasło: </br> <input name="haslo2" type="password"> </br>
            <label><input type="checkbox" name="regulamin"> Akceptuję regulamin</label> </br>
            <?php
                if(isset($_SESSION['e_regulamin']))
                {
                    echo '<div class = "error">' . $_SESSION['e_regulamin'] . '</div>';
                    unset($_SESSION['e_regulamin']);
                }
            ?>
            <!-- dodanie pola o nie byciu robotem-->
            <div class="g-recaptcha" data-sitekey="6LcEhgUbAAAAAKh8JRQ5Pp1PNsniQcYcM6SFIIFw"></div>
            <?php
                if(isset($_SESSION['e_bot']))
                {
                    echo '<div class = "error">' . $_SESSION['e_bot'] . '</div>';
                    unset($_SESSION['e_bot']);
                }
            ?>
            </br>
            <input type="submit" value="Zarejestruj się">
         </form>
    </body>

 



</html>