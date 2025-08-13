<?php
//Datenbank Informationen
require_once 'db_connect.php';
require 'session.php';
$conn = getDbConnection();

$filter = strtolower($_GET['filter'] ?? '');
$sortBy = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? 'asc';

$allowedSortFields = ['idPerson', 'Anrede', 'Vorname', 'Nachname', 'Geburtstag', 'e-mail', 'Telefonnummer'];

$sql = "SELECT idPerson, Anrede, Vorname, Nachname, Geburtstag, `e-mail`, Telefonnummer FROM person";

if ($filter !== '') {
    $sql .= " WHERE 
        LOWER(idPerson) LIKE ? OR 
        LOWER(Anrede) LIKE ? OR 
        LOWER(Vorname) LIKE ? OR 
        LOWER(Nachname) LIKE ? OR 
        LOWER(`e-mail`) LIKE ? OR 
        LOWER(Telefonnummer) LIKE ?";
}

if (in_array($sortBy, $allowedSortFields)) {
    $sql .= " ORDER BY `$sortBy` " . ($order === 'desc' ? 'DESC' : 'ASC');
}

$stmt = $conn->prepare($sql);

if ($filter !== '') {
    $likeFilter = "%$filter%";
    $stmt->bind_param("ssssss", $likeFilter, $likeFilter, $likeFilter, $likeFilter, $likeFilter, $likeFilter);
}

if (!$stmt->execute()) {
    die("Fehler beim Abfragen vom Ort: " . $stmt->error);
}
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Personenliste</title>
    <link rel="stylesheet" type="text/css" href="monitoring.css">
</head>
<body>
<h1>Personenliste</h1>
<form method="get">
    <input type="text" name="filter" placeholder="Suche" value="<?= htmlspecialchars($filter) ?>">
    <select name="sort">
        <option value="">Sortieren nach</option>
        <?php foreach ($allowedSortFields as $field): ?>
            <option value="<?= $field ?>" <?= $sortBy === $field ? 'selected' : '' ?>><?= $field ?></option>
        <?php endforeach; ?>
    </select>
    <select name="order">
        <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>Aufsteigend</option>
        <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Absteigend</option>
    </select>
    <input type="submit" value="Anwenden">
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Anrede</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Geburtstag</th>
        <th>E-Mail</th>
        <th>Telefonnummer</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['idPerson']) ?></td>
            <td><?= htmlspecialchars($row['Anrede']) ?></td>
            <td><?= htmlspecialchars($row['Vorname']) ?></td>
            <td><?= htmlspecialchars($row['Nachname']) ?></td>
            <td><?= htmlspecialchars($row['Geburtstag']) ?></td>
            <td><?= htmlspecialchars($row['e-mail']) ?></td>
            <td><?= htmlspecialchars($row['Telefonnummer']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>