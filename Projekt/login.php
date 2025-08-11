<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
session_start();
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

$pw = '';
$benutzerID = '';

// Benutzer anhand der E-Mail suchen
$stmtSelectPerson = $conn->prepare("SELECT * FROM person WHERE `e-mail` = ?");
if (!$stmtSelectPerson) {
    die("Fehler beim Vorbereiten der checkEmail-Abfrage: " . $conn->error);
}

$stmtSelectPerson->bind_param("s", $_POST['username']);
if (!$stmtSelectPerson->execute()) {
    die("Fehler beim Abfragen der Email." . $stmtSelectPerson->error);
}

$result = $stmtSelectPerson->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $pw = $row['passwort'];
    $benutzerID = $row['idPerson'];
    if (password_verify($_POST["password"], $pw)) {
        // Login erfolgreich – Session setzen
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["BenutzerId"] = $benutzerID;

        header("Location: landingPage.php");
    } else {
        die("Ungültiges Passwort.<br>");
        //echo "<a href='loginPage.php'>Zurück zum Login</a>";
    }
} else {
    die("Benutzername oder Passwort Falsch");
}


// Verbindung schließen
$conn->close();
?>