<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php

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
$stmtBenutzer = $conn->prepare("INSERT INTO Benutzer (`E-Mail`, Passwort) VALUES (?, ?)");
if (!$stmtBenutzer) {
    die("Fehler beim Vorbereiten der Benutzer-Abfrage: " . $conn->error);
}
$email = $_POST['E-Mail'];
$passwort = password_hash($_POST['Passwort'], PASSWORD_DEFAULT);
$stmtBenutzer->bind_param("ss", $email, $passwort);

if (!$stmtBenutzer->execute()) {
    die("Fehler beim Einfügen des Benutzers. Möglicherweise ist die E-Mail bereits vergeben.<br>" . $stmtBenutzer->error);
}

$benutzerID = $stmtBenutzer->insert_id;

// Person einfügen
$stmtPerson = $conn->prepare("INSERT INTO Person (BenutzerID, Anrede, Vorname, Nachname, Geburtstag, Strasse, Wohnort, PLZ, Telefonnummer, Bundesland, ProfilBild)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmtPerson) {
    die("Fehler beim Vorbereiten der Personen-Abfrage: " . $conn->error);
}

$stmtPerson->bind_param(
    "issssssssss",
    $benutzerID,
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

if (!$stmtPerson->execute()) {
    die("Fehler beim Einfügen der Person.<br>" . $stmtPerson->error);
}

// Verbindung schließen
$stmtBenutzer->close();
$stmtPerson->close();
$conn->close();

// Weiterleitung
header("Location: landingPage.php");
exit;
?>
