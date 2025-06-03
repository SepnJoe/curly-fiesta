<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
$data = array(
$_POST['anrede'],
$_POST['Vorname'],
$_POST['Nachname'],
$_POST['Geburtstag'],
$_POST['E-Mail'],
password_hash($_POST['Passwort'],PASSWORD_DEFAULT),
$_POST['Strasse'],
$_POST['Wohnort'],
$_POST['PLZ'],
$_POST['Telefonnummer'],
$_POST['bundesland']);


 $csv=fopen("daten.csv","a");
        if(!$csv)
          {
            echo "Datei konnte nicht zum Schreiben geöffnet werden.";
            exit;
          }

    fputcsv($csv,$data,";");

        echo "Ihre Eingaben wurden gespeichert.";

    fclose($csv);
?>
