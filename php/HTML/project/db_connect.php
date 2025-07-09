<?php
function getDbConnection()
{
    $host = 'localhost';
    $username = 'root';
    $password = 'root';
    $database = 'testdb';

    // Verbindung aufbauen
    $conn = new mysqli($host, $username, $password, $database);

    // Fehlerbehandlung
    if ($conn->connect_error) {
        die("Fehler bei der Verbindung zur Datenbank: " . $conn->connect_error);
    }

    return $conn;
}
?>