<?php
 session_start();
require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno !=0)
{
    echo "ERROR:" . $polaczenie->connect_errno;
}
else{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $sql = "SELECT * FROM uzytkownicy WHERE user='$login' AND pass='$haslo'";
 
    //wysyłanie zapytania do bazy 
    if($rezultat = @$polaczenie->query($sql))
 //query jest tu medotą obiektu $polaczenie
 //ten if jest po to, że gdy w zapytaniu będzie literówka to zmienna $rezultat przyjmie wartość false i ten if się nie spełni
 //sprawdzamy teraz ile rekordów nam zwróci zapytanie: 1 czy 0
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow >0) //udało się komuś zalogować
         //zanim będziemy mogli odczytać wartości wszystkich kolumn to najpierw musimy stworzyć tablice, która je przechowa
        {   $_SESSION['zalogowany'] = true; //zmienna potwierdzająca zalogowanie; jeśli udało się zalogować to istnieje zmienna zalogowany
            
            $wiersz = $rezultat->fetch_assoc();
            //wyciągnięcie loginu uztkowanika, który się zalogował z tabeli - jako przykład
            // wyciągamy tę wartość z tablicy asocjacyjnej zwanej wiersz z szuflatki o nazwie user
           // $user = $wiersz['user'];

           //wkładanie danych do sesji
            $_SESSION['id'] = $wiersz['id'];
            $_SESSION['user'] = $wiersz['user'];
            $_SESSION['drewno'] = $wiersz['drewno'];
            $_SESSION['kamien'] = $wiersz['kamien'];
            $_SESSION['zboze'] = $wiersz['zboze'];
            $_SESSION['email'] = $wiersz['email'];
            $_SESSION['dnipremium'] = $wiersz['dnipremium'];

            unset($_SESSION['blad']);
            $rezultat->free_result();  
            header('Location: gra.php'); //przekierowanie  
        }else //nie udało się zalogować
        {
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('Location: index.php');
        }
    }
}
    $polaczenie->close();

?>