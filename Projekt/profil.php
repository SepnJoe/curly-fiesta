<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
require 'db_connect.php';
require 'session.php';
$conn = getDbConnection();

// Prüfen, ob Benutzer eingeloggt ist
if (!isset($_SESSION['BenutzerId'])) {
    header("Location: loginPage.php");
    exit;
}

// Benutzerinformationen abrufen
$stmtSelectPerson = $conn->prepare("SELECT * FROM person p 
    INNER JOIN anschrift a on p.fk_idAnschrift = a.idAnschrift 
    INNER JOIN ort o on a.fk_idOrt = o.idOrt
    WHERE idPerson = ?");
if (!$stmtSelectPerson) {
    die("Fehler beim Vorbereiten der selectPerson-Abfrage: " . $conn->error);
}

$stmtSelectPerson->bind_param("i", $_SESSION['BenutzerId']);
if (!$stmtSelectPerson->execute()) {
    die("Fehler beim Abfragen der Email." . $stmtSelectPerson->error);
}

$result = $stmtSelectPerson->get_result();
$row = $result->fetch_assoc();
if (!$row) {
    die("Keine Daten Gefunden");
}

// Daten extrahieren
$anrede = $row['anrede'];
$vorname = $row['vorname'];
$nachname = $row['nachname'];
$geburtstag = $row['geburtstag'];
$email = $row['e-mail'];
$telefonnummer = $row['telefonnummer'];
$profilBild = $row['profilbild'];
$fk_idAnschrift = $row['fk_idAnschrift'];
$strasse = $row['strasse'];
$hausnummer = $row['hausnummer'];
$plz = $row['plz'];
$ort = $row['ort'];

// Verbindung schließen
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="styling.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Profil</h1>
            <?php if ($profilBild): ?>
                <div style="text-align: end;">
                    <img src="data:image/jpeg;base64,<?= $profilBild ?>" alt="Profilbild">
                </div>
            <?php endif; ?>
            <img src="assets/logo.png" alt="Logo" class="logo">
            <nav>
                <a href="landingPage.php" style="margin-left: 20px">Produkt</a>
                <a href="aenderung.php" style="margin-left: 20px">Daten ändern</a>
                <a href="logout.php" style="margin-left: 20px">Logout</a>
            </nav>
            <br>
            <br>
        </header>

        <main>
            <p><strong>Anrede:</strong> <?= htmlspecialchars($anrede) ?></p>
            <p><strong>Vorname:</strong> <?= htmlspecialchars($vorname) ?></p>
            <p><strong>Nachname:</strong> <?= htmlspecialchars($nachname) ?></p>
            <p><strong>Geburtstag:</strong> <?= htmlspecialchars($geburtstag) ?></p>
            <p><strong>Strasse:</strong> <?= htmlspecialchars($strasse) ?></p>
            <p><strong>Hausnummer:</strong> <?= htmlspecialchars($hausnummer) ?></p>
            <p><strong>PLZ:</strong> <?= htmlspecialchars($plz) ?></p>
            <p><strong>Ort:</strong> <?= htmlspecialchars($ort) ?></p>
            <p><strong>Telefonnummer:</strong> <?= htmlspecialchars($telefonnummer) ?></p>
        </main>
    </div>
</body>

</html>