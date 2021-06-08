<?php
 session_start();

if(( !isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno !=0)
{
    echo "ERROR:" . $polaczenie->connect_errno;
}
else
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    
   //wysyłanie zapytania do bazy 
     if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
    mysqli_real_escape_string($polaczenie,$login))))
        //query jest tu medotą obiektu $polaczenie
        //ten if jest po to, że gdy w zapytaniu będzie literówka to zmienna $rezultat przyjmie wartość false i ten if się nie spełni
        //sprawdzamy teraz ile rekordów nam zwróci zapytanie: 1 czy 0
        {
          $ilu_userow = $rezultat->num_rows;
          if($ilu_userow >0)
          { //udało się komuś zalogować
             //wyciągnięcie loginu uztkowanika, który się zalogował z      tabeli - jako przykład
                // wyciągamy tę wartość z tablicy asocjacyjnej zwanej wiersz z szuflatki o nazwie user
            $wiersz = $rezultat->fetch_assoc();
          
            
              //weryfikacja hasha

            if(password_verify($haslo, $wiersz['pass']))
              {

                 //zanim będziemy mogli odczytać wartości wszystkich kolumn to najpierw musimy stworzyć tablice, która je przechowa
                 $_SESSION['zalogowany'] = true; //zmienna potwierdzająca zalogowanie; jeśli udało się zalogować to istnieje zmienna zalogowany
                
                //wkładanie danych do sesji
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['user'] = $wiersz['user'];
                $_SESSION['drewno'] = $wiersz['drewno'];
                $_SESSION['kamien'] = $wiersz['kamien'];
                $_SESSION['zboze'] = $wiersz['zboze'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['dnipremium'] = $wiersz['dnipremium'];

                //gdy udało się zalogowac usuwamy z sesji błąd
                unset($_SESSION['blad']);
                $rezultat->free_result();  
                header('Location: gra.php'); 
              }

              else  //reakcja na nie znalezienie if spełniającego hash
              {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
              }
          }
             //reakcja na nie znalezienie danego usera
            else 
            {
              $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
              header('Location: index.php');
            }
                    
          }

 
    $polaczenie->close();
}

?>