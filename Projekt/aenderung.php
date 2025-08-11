<!-- Titel:
     Autor: Feldinger Niklas
     Datum:  -->

<?php
require_once 'db_connect.php';
$conn = getDbConnection();
session_start();

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

<!--HTML und CSS - Erste Übung
   Autor: Feldinger niklas
   Datum: 06.05.2024
   Version HTML 5 -->

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
            <h1>Daten bearbeiten</h1>
            <br>
            <br>
        </header>

        <body>
            <div>
                <form action="update.php" method="post" enctype="multipart/form-data">
                    <div class="radio-group">
                        <div>
                            <input type="radio" name="Anrede" id="Feld_AnredeAuswahl1" value="Herr" <?php if ($anrede == "Herr"): ?> checked <?php endif; ?> />
                            <label for="Feld_AnredeAuswahl1">Herr</label>
                        </div>
                        <div>
                            <input type="radio" name="Anrede" id="Feld_AnredeAuswahl2" value="Frau" <?php if ($anrede == "Frau"): ?>checked <?php endif; ?> />
                            <label for="Feld_AnredeAuswahl2">Frau</label>
                        </div>
                        <div>
                            <input type="radio" name="Anrede" id="Feld_AnredeAuswahl3" value="Divers" <?php if ($anrede == "Divers"): ?>checked <?php endif; ?> />
                            <label for="Feld_AnredeAuswahl3">Divers</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Feld_Vorname">Vorname</label>
                        <input type="text" name="Vorname" id="Feld_Vorname" required value="<?= $vorname ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Nachname">Nachname</label>
                        <input type="text" name="Nachname" id="Feld_Nachname" required value="<?= $nachname ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Geburtstag">Geburtstag</label>
                        <input type="date" name="Geburtstag" id="Feld_Geburtstag" value="<?= $geburtstag ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_E-Mail">E-Mail</label>
                        <input type="email" name="EMail" id="Feld_E-Mail" required value="<?= $email ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Passwort">Passwort</label>
                        <input type="password" name="Passwort" id="Feld_Passwort">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="Feld_Strasse">Strasse</label>
                        <input type="text" name="Strasse" id="Feld_Strasse" value="<?= $strasse ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Hausnummer">Hausnummer</label>
                        <input type="text" name="Hausnummer" id="Feld_Hausnummer" value="<?= $hausnummer ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Wohnort">Wohnort</label>
                        <input type="text" name="Wohnort" id="Feld_Wohnort" required value="<?= $ort ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_PLZ">PLZ</label>
                        <input type="number" name="PLZ" id="Feld_PLZ" value="<?= $plz ?>">
                    </div>

                    <div class="form-group">
                        <label for="Feld_Telefonnummer">Telefonnummer</label>
                        <input type="tel" name="Telefonnummer" id="Feld_Telefonnummer" value="<?= $telefonnummer?>">
                    </div>

                    <hr>

                    <div class="file-upload">
                        <label for="fileToUpload">Select image to upload:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </div>

                    <div class="form-actions">
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </div>
                </form>
                <hr>

            </div>
        </body>

</html>