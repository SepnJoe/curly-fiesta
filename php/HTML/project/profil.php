<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
session_start();
require_once 'db_connect.php';
$conn = getDbConnection();

// Prüfen, ob Benutzer eingeloggt ist
if (!isset($_SESSION['BenutzerId'])) {
    header("Location: loginPage.php");
    exit;
}

// Benutzerinformationen abrufen
$stmt = "SELECT * FROM dbo.Person WHERE PersonID = ?";
$params = array($_SESSION['BenutzerId']);
$selectPerson = sqlsrv_query($conn, $stmt, $params);

if ($selectPerson === false) {
    die("Fehler beim Abrufen der Daten.");
}

$person = sqlsrv_fetch_array($selectPerson, SQLSRV_FETCH_ASSOC);
if (!$person) {
    die("Benutzer nicht gefunden.");
}

// Daten extrahieren
$anrede = $person['Anrede'];
$vorname = $person['Vorname'];
$nachname = $person['Nachname'];
$geburtstag = $person['Geburtstag'];
$strasse = $person['Strasse'];
$wohnort = $person['Wohnort'];
$plz = $person['PLZ'];
$telefonnummer = $person['Telefonnummer'];
$bundesland = $person['Bundesland'];
$profilBild = $person['ProfilBild'];

// Verbindung schließen
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
<header>
    <h1>Profil</h1>
    <img src="assets/logo.png" alt="Logo" class="logo">
    <?php if ($profilBild): ?>
        <img src="data:image/jpeg;base64,<?= $profilBild ?>" alt="Profilbild" style="max-width: 200px;">
    <?php endif; ?>
    <nav>
        <a href="logout.php" style="margin-left: 20px">Logout</a>
        <a href="aenderung.php" style="margin-left: 20px">Daten ändern</a>
    </nav>
</header>

<main>
    <p><strong>Anrede:</strong> <?= htmlspecialchars($anrede) ?></p>
    <p><strong>Vorname:</strong> <?= htmlspecialchars($vorname) ?></p>
    <p><strong>Nachname:</strong> <?= htmlspecialchars($nachname) ?></p>
    <p><strong>Geburtstag:</strong> <?= $geburtstag ? date_format($geburtstag, "Y-m-d") : '' ?></p>
    <p><strong>Strasse:</strong> <?= htmlspecialchars($strasse) ?></p>
    <p><strong>Wohnort:</strong> <?= htmlspecialchars($wohnort) ?></p>
    <p><strong>PLZ:</strong> <?= htmlspecialchars($plz) ?></p>
    <p><strong>Telefonnummer:</strong> <?= htmlspecialchars($telefonnummer) ?></p>
    <p><strong>Bundesland:</strong> <?= htmlspecialchars($bundesland) ?></p>
</main>
</body>
</html>
