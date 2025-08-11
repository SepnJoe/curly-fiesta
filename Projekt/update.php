<?php
session_start();
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

$anrede = '';
$vorname = '';
$nachname = '';
$geburtstag = '';
$email = '';
$passwort = '';
$telefonnummer = '';
$profilBild = '';
$fk_idAnschrif = '';
$strasse = '';
$hausnummer = '';
$plz = '';
$ort = '';

// Benutzer anhand der benutzerId in Session suchen
$stmtSelectPerson = $conn->prepare("SELECT * FROM person WHERE idPerson = ?");
if (!$stmtSelectPerson) {
    die("Fehler beim Vorbereiten der Abfrage: " . $conn->error);
}

$stmtSelectPerson->bind_param("s", $_SESSION['BenutzerId']);
if (!$stmtSelectPerson->execute()) {
    die("Fehler beim Abfragen des Benutzers." . $stmtSelectPerson->error);
}

$result = $stmtSelectPerson->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $anrede = $row['anrede'];
    $vorname = $row['vorname'];
    $nachname = $row['nachname'];
    $geburtstag = $row['geburtstag'];
    $emailAlt = $row['e-mail'];
    $passwortAlt = $row['passwort'];
    $telefonnummer = $row['telefonnummer'];
    $profilBild = $row['profilbild'];
    $fk_idAnschrift = $row['fk_idAnschrift'];
} else {
    die("Benutzername oder Passwort Falsch");
}

//1 prüfen ob email vorhanden
$email = $_POST['EMail'];
$stmtCheckMail = $conn->prepare("SELECT * FROM person WHERE `e-mail` = ?");
if (!$stmtCheckMail) {
    die("Fehler beim Vorbereiten der checkEmail-Abfrage: " . $conn->error);
}

$stmtCheckMail->bind_param("s", $email);
if (!$stmtCheckMail->execute()) {
    die("Fehler beim Abfragen der Email." . $stmtCheckMail->error);
}

$result = $stmtCheckMail->get_result();
$row = $result->fetch_assoc();

if ($emailAlt != $email && $row) {
    die("Fehler! E-Mail bereits vorhanden.");
}

//2 prüfen ob Ort vorhanden - ggf einfügen - id speichern
$plz = $_POST['PLZ'];
$ort = $_POST['Wohnort'];

$stmtCheckOrt = $conn->prepare("SELECT idOrt FROM ort WHERE plz = ? AND ort = ?");
if (!$stmtCheckOrt) {
    die("Fehler beim Vorbereiten der checkOrt-Abfrage: " . $conn->error);
}

$stmtCheckOrt->bind_param("ss", $plz, $ort);
if (!$stmtCheckOrt->execute()) {
    die("Fehler beim Abfragen vom Ort: " . $stmtCheckOrt->error);
}

$result = $stmtCheckOrt->get_result();
$row = $result->fetch_assoc();
$idOrt;
if ($row) {
    $idOrt = $row['idOrt']; // Ort existiert, ID gespeichert
} else {
    // Ort existiert nicht
    $stmtInsertOrt = $conn->prepare("INSERT INTO ort (plz, ort, fk_idLand) VALUES (?, ?, 1)");
    if (!$stmtInsertOrt) {
        die("Fehler beim Vorbereiten der ort Insert-Abfrage: " . $conn->error);
    }

    $stmtInsertOrt->bind_param("ss", $plz, $ort);
    if (!$stmtInsertOrt->execute()) {
        die("Fehler beim Einfügen des Ortes: " . $stmtInsertOrt->error);
    }

    $idOrt = $stmtInsertOrt->insert_id; // Neue ID nach dem Insert
}


//3 prüfen ob adresse vorhanden - ggf einfügen - id speichern
$strasse = $_POST['Strasse'];
$hausnummer = $_POST['Hausnummer'];

$stmtCheckAnschrift = $conn->prepare("SELECT idAnschrift FROM anschrift WHERE strasse = ? AND hausnummer = ? AND fk_idOrt = ?");
if (!$stmtCheckAnschrift) {
    die("Fehler beim Vorbereiten der checkAnschrift-Abfrage: " . $conn->error);
}

$stmtCheckAnschrift->bind_param("ssi", $strasse, $hausnummer, $idOrt);
if (!$stmtCheckAnschrift->execute()) {
    die("Fehler beim Abfragen vom Ort: " . $stmtCheckAnschrift->error);
}

$result = $stmtCheckAnschrift->get_result();
$row = $result->fetch_assoc();
$idAnschrift;
if ($row) {
    $idAnschrift = $row['idAnschrift']; // Anschrift existiert, ID gespeichert
} else {
    // Anschrift existiert nicht
    $stmtInsertAnschrift = $conn->prepare("INSERT INTO anschrift (strasse, hausnummer, fk_idOrt) VALUES (?, ?, ?)");
    if (!$stmtInsertAnschrift) {
        die("Fehler beim Vorbereiten der anschrift Insert-Abfrage: " . $conn->error);
    }

    $stmtInsertAnschrift->bind_param("ssi", $strasse, $hausnummer, $idOrt);
    if (!$stmtInsertAnschrift->execute()) {
        die("Fehler beim Einfügen der Anschrift: " . $stmtInsertAnschrift->error);
    }

    $idAnschrift = $stmtInsertAnschrift->insert_id; // Neue ID nach dem Insert
}

//4 person updaten
$stmtUpdatePerson = $conn->prepare("
    UPDATE person 
    SET anrede = ?, vorname = ?, nachname = ?, geburtstag = ?, `e-mail` = ?, passwort = ?, telefonnummer = ?, profilbild = ?, fk_idAnschrift = ?
    WHERE idPerson = ?");
if (!$stmtUpdatePerson) {
    die("Fehler beim Vorbereiten der person update-Abfrage: " . $conn->error);
}

// Bildverarbeitung (optional)
$encoded = null;
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['fileToUpload']['tmp_name'];
    $imageData = file_get_contents($imageTmpPath);
    $encoded = base64_encode($imageData);
}

if ($_POST['Passwort']) {
    $passwort = password_hash($_POST['Passwort'], PASSWORD_DEFAULT);
} else{
    $passwort = $passwortAlt;
}

$stmtUpdatePerson->bind_param("ssssssssii", $_POST['Anrede'], $_POST['Vorname'], $_POST['Nachname'], $_POST['Geburtstag'], $_POST['EMail'], $passwort, $_POST['Telefonnummer'], $encoded, $idAnschrift, $_SESSION['BenutzerId']);

if (!$stmtUpdatePerson->execute()) {
    die("Fehler beim updaten der Person: " . $stmtUpdatePerson->error);
}

// Verbindung schließen
//$stmtBenutzer->close();
//$stmtPerson->close();
$conn->close();

// Weiterleitung
header("Location: profil.php");
exit;
