<?php
//Datenbank Informationen
require_once 'db_connect.php';
$conn = getDbConnection();

try {
    if ($_POST['fileToUpload'] === ''){
        //Kein Bild Upload
    } else{
        $image = $_POST['fileToUpload']; // Convert Bild zu base64
        $data = fopen($image, 'rb');
        $size = filesize($image);
        $contents = fread($data, $size);
        fclose($data);
        $encoded = base64_encode($contents);
    }
    //----------------------------------------Prepare Update Person---------------------------------------------------
    $stmt = "Update dbo.Person Set 
                      Anrede = ?,
                      Vorname = ?,
                      Nachname = ?,
                      Geburtstag = ?,
                      Strasse = ?,
                      Wohnort = ?,
                      PLZ = ?,
                      Telefonnummer = ?,
                      Bundesland = ?,
                      ProfilBild = ?
                      Where [PersonID] = '" . $_COOKIE['BenutzerId'] . "';";

    $params = array($_POST['anrede'],$_POST['Vorname'],$_POST['Nachname'],$_POST['Geburtstag'],$_POST['Strasse'],
        $_POST['Wohnort'],$_POST['PLZ'],$_POST['Telefonnummer'],$_POST['bundesland'], $encoded);

    $updatePerson = sqlsrv_query($conn, $stmt, $params); //Ausführen Update

    if ($updatePerson === false) {
        die("Fehler Aufgetreten <br>");
    } else {
        header("Location: profil.php");
    }
}catch (PDOException $e){

    echo ( 'Fehler: ' . $e->getMessage());
}

switch ($_POST['Bearbeiten']) {
    case "Anrede":
    case "Vorname":
    case "Nachname":
    case "Strasse":
    case "Wohnort":
    case "PLZ":
    case "Telefonnummer":
    case "Bundesland":
        echo '<input type="text" name="Aenderung" id="Feld_Aenderung" value="" required="required" autofocus>';
        break;
    case "Geburtsdatum":
        echo '<input type="date" name="Geburtstag" id="Feld_Geburtstag" value="">';
        break;
    case "ProfilBild":
        echo '<input type="file" name="fileToUpload" id="fileToUpload">';
        break;
    default:
        echo "Keine Gültige Änderung";
}

