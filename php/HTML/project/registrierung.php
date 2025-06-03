<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
session_start();
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

// Bildverarbeitung (optional)
$encoded = null;
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['fileToUpload']['tmp_name'];
    $imageData = file_get_contents($imageTmpPath);
    $encoded = base64_encode($imageData);
}

// Benutzer einfügen
$stmtBenutzer = "INSERT INTO dbo.Benutzer ([E-Mail], Passwort) VALUES (?, ?)";
$paramsBenutzer = array(
    $_POST['E-Mail'],
    password_hash($_POST['Passwort'], PASSWORD_DEFAULT)
);

$insertBenutzer = sqlsrv_query($conn, $stmtBenutzer, $paramsBenutzer);
if ($insertBenutzer === false) {
    die("Fehler beim Einfügen des Benutzers. Möglicherweise ist die E-Mail bereits vergeben.<br>");
}

// Person einfügen
$stmtPerson = "INSERT INTO dbo.Person (Anrede, Vorname, Nachname, Geburtstag, Strasse, Wohnort, PLZ, Telefonnummer, Bundesland, ProfilBild)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$paramsPerson = array(
    $_POST['anrede'],
    $_POST['Vorname'],
    $_POST['Nachname'],
    $_POST['Geburtstag'],
    $_POST['Strasse'],
    $_POST['Wohnort'],
    $_POST['PLZ'],
    $_POST['Telefonnummer'],
    $_POST['bundesland'],
    $encoded
);

$insertPerson = sqlsrv_query($conn, $stmtPerson, $paramsPerson);
if ($insertPerson === false) {
    die("Fehler beim Einfügen der Person.<br>");
}

// Verbindung schließen
sqlsrv_close($conn);

// Weiterleitung
header("Location: landingPage.php");
exit;
?>
