<?php
require_once 'db_connect.php';
$conn = getDbConnection();
session_start();

// Prüfen, ob Benutzer eingeloggt ist
if (!isset($_SESSION['BenutzerId'])) {
    header("Location: loginPage.php");
    exit;
}

$feld = $_GET['feld'];
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
            <h1><?= $feld ?> bearbeiten</h1>
            <br>
            <br>
        </header>

        <main>

            <form action="landingPage.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="feldInput"><?= $feld ?></label>

                    <?php
                    switch ($feld) {
                        case "Anrede": ?>
                            <div class="radio-group">
                                <div>
                                    <input type="radio" name="feldInput" id="Feld_AnredeAuswahl1" value="Herr" checked />
                                    <label for="Feld_AnredeAuswahl1">Herr</label>
                                </div>
                                <div>
                                    <input type="radio" name="feldInput" id="Feld_AnredeAuswahl2" value="Frau" />
                                    <label for="Feld_AnredeAuswahl2">Frau</label>
                                </div>
                                <div>
                                    <input type="radio" name="feldInput" id="Feld_AnredeAuswahl3" value="Divers" />
                                    <label for="Feld_AnredeAuswahl3">Divers</label>
                                </div>
                            </div>
                        <?php
                            break;

                        case "Geburtstag": ?>
                            <div class="form-group">
                                <input type="date" name="feldInput" id="Feld_Geburtstag">
                            </div>
                        <?php
                            break;

                        default: ?>
                            <input type="text" name="feldInput" id="feldInput" required>
                    <?php
                            break;
                    } ?>


                </div>

                <div class="form-actions">
                    <input type="submit" value="Submit">
                    <input type="reset" value="Clear">
                </div>
            </form>

        </main>
    </div>
</body>

</html>