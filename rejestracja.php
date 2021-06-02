
<?php
    session_start();
    //sprawdzenie czy taka zmienna istnieje, jeśli tak oznacza to, że formularz rejestracji został już wysłany
    if(!isset($_POST['nick'])){
         
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <header>
        <meta charset="utf-8">
        <title>Rejsetracja</title>
        <script src="https://www.google.com/recaptcha/api.js"></script>
    <header>

    <body>

        <h2>Zarejestruj się za darmo już dziś!</h2>
        <form method="post">
            Nick: </br> <input name="nick" type="text"> </br>
            E-mail: </br> <input name="email" type="text"> </br>
            Hasło: </br> <input name="haslo" type="password"> </br>
            Powtórz Hasło: </br> <input name="haslo2" type="password"> </br>
            <label><input type="checkbox" name="regulamin"> Akceptuję regulamin</label> </br>
            <!-- dodanie pola o nie byciu robotem-->
            <div class="g-recaptcha" data-sitekey="6LcEhgUbAAAAAKh8JRQ5Pp1PNsniQcYcM6SFIIFw"></div>
            </br>
            <input type="submit" value="Zarejestruj się">
         </form>
    </body>

 



</html>