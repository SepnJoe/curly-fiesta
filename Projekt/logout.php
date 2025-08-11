<!-- Titel:
     Autor: Feldinger Niklas
     Datum:  -->

<?php
// Session-Daten löschen
session_start();
session_unset();
session_destroy();

// Weiterleitung zum Login
header("Location: loginPage.php");
exit;
?>
