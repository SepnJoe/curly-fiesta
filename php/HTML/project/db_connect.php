<?php
function getDbConnection()
{
    $server = 'serverniklas.database.windows.net';
    $username = 'myUser';
    $password = 'ABC8090DEF?';
    $database = 'myDatabase';

    $connectionOptions = array(
        "Database" => $database,
        "Uid" => $username,
        "PWD" => $password
    );

    $conn = sqlsrv_connect($server, $connectionOptions);
    if ($conn === false) {
        die("Fehler bei der Verbindung zur Datenbank.");
    }
    return $conn;
}
?>