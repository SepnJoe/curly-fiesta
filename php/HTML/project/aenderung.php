<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

$anrede = '';
$vorname = '';
$nachname = '';
$geburtstag = '';
$strasse = '';
$wohnort = '';
$plz = '';
$telefonnummer = '';
$bundesland = '';
$profilBild = '';

try {

    $stmt = "Select * FROM dbo.Person Where [PersonID] = '" . $_COOKIE['BenutzerId'] . "';";

    $selectPerson = sqlsrv_query($conn, $stmt); //Ausführen Update

    if ($selectPerson === false) {
        die("Fehler Aufgetreten <br>");
    } else {
        while ($row = sqlsrv_fetch_array($selectPerson, SQLSRV_FETCH_ASSOC)) { //Daten in Variablen Speichern

            $anrede = $row['Anrede'];
            $vorname = $row['Vorname'];
            $nachname = $row['Nachname'];
            $geburtstag = $row['Geburtstag'];
            $strasse = $row['Strasse'];
            $wohnort = $row['Wohnort'];
            $plz = $row['PLZ'];
            $telefonnummer = $row['Telefonnummer'];
            $bundesland = $row['Bundesland'];
            $profilBild = $row['ProfilBild'];
        }
    }
} catch (PDOException $e) {

    echo('Fehler: ' . $e->getMessage());
}
echo '
<!--HTML und CSS - Erste Übung
   Autor: Feldinger niklas
   Datum: 06.05.2024
   Version HTML 5 -->
<!DOCTYPE html>
<link rel="stylesheet" href="styling.css">
<html>
<header>
  <h1> Daten bearbeiten </h1>
  <img src="logo%20Raiffeisen.png" alt="Logo" class="logo">
  <a href="Raiffeisen%20Produkt.php">zum Produkt</a>
  <br>
  <br>
</header>
<body>
<div>
  <form action="update.php" method="post">
    <input type="radio" name="anrede" id="Feld_AnredeAuswahl1" value="Herr" checked/>
    <label for="Feld_AnredeAuswahl1">Herr</label>
    <input type="radio" name="anrede" id="Feld_AnredeAuswahl2" value="Frau" />
    <label for="Feld_AnredeAuswahl2">Frau</label>
    <br>
    <label for="Feld_Vorname">Vorname</label>
    <input type="text" name="Vorname" id="Feld_Vorname" value=' . $vorname . ' required="required" autofocus>
    <label for="Feld_Nachname">Nachname</label>
    <input type="text" name="Nachname" id="Feld_Nachname" value=' . $nachname . ' required="required">
    <label for="Feld_Geburtstag">Geburtstag</label>
    <input type="date" name="Geburtstag" id="Feld_Geburtstag" value="" required="required">
    <label for="Feld_E-mail">E-Mail</label>
    <input type="email" name="E-Mail" id="Feld_E-Mail" value=' . $_COOKIE['username'] . '>
    <label for="Feld_Passwort">Passwort</label>
    <input type="password" name="Passwort" id="Feld_Passwort" value="" required="required">
    <hr>
    <label for="Feld_Strasse">Strasse </label>
    <input type="text" name="Strasse" id="Feld_Strasse" value=' . $strasse . '>
    <label for="Feld_Wohnort">Wohnort</label>
    <input type="text" name="Wohnort" id="Feld_Wohnort" value=' . $wohnort . ' required="required">
    <label for="Feld_PLZ">PLZ</label>
    <input type="number" name="PLZ" id="Feld_PLZ" value=' . $plz . '>
    <label for="Feld_Telefonnummer">Telefonnummer</label>
    <input type="tel" name="Telefonnummer" id="Feld_Telefonnummer" value=' . $telefonnummer . '>
    <label for="bland">Bundesland</label>
    <select name="bundesland" id="bLand">
      <option value="burgenland">Burgenland</option>
      <option value="kärnten">Kaernten</option>
      <option value="niederösterreich">Niederoesterreich</option>
      <option value="oberösterreich">Oberoesterreich</option>
      <option value="salzburg">Salzburg</option>
      <option value="steiermark">Steiermark</option>
      <option value="tirol">Tirol</option>
      <option value="vorarlberg">Vorarlberg</option>
      <option value="wien">Wien</option>
    </select>
    <hr>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Submit">
    <input type="reset" value="clear">
  </form>
  <hr>'
?>
</div>
</body>
</html>