<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

$Pw =''; //Hier wird das Selectede Passwort aus der Datenbank Gespeichert
$benutzerID =''; //Hier wird das Selectede Passwort aus der Datenbank Gespeichert

// Benutzer anhand der E-Mail suchen
$stmt = "SELECT * FROM dbo.Benutzer WHERE [E-Mail] = ?;";
$params = array($_POST['username']);

$selectBenutzer = sqlsrv_query($conn, $stmt, $params);

if ($selectBenutzer === false) {
    die("Fehler beim Abrufen der Benutzerdaten.<br>");
} else {
    while ($row = sqlsrv_fetch_array($selectBenutzer, SQLSRV_FETCH_ASSOC)) {
        $Pw = $row['Passwort'];
        $benutzerID = $row['BenutzerId'];
    }

    if (password_verify($_POST["password"], $Pw)) {
        // Login erfolgreich – Session setzen
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["BenutzerId"] = $benutzerID;

        header("Location: landingPage.php");
        exit;
    } else {
        echo "Ungültiges Passwort.<br>";
        echo "<a href='loginPage.php'>Zurück zum Login</a>";
    }
}

// Verbindung schließen
sqlsrv_close($conn);
?>