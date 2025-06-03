<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<?php
session_start();

// Session-Daten löschen
session_unset();
session_destroy();

// Weiterleitung zum Login
header("Location: loginPage.php");
exit;
?>
