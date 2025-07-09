<?php
// Dummy-Daten simulieren
$data = [
    ["Vorname" => "Anna", "Nachname" => "Müller", "Land" => "Deutschland"],
    ["Vorname" => "Lukas", "Nachname" => "Schmidt", "Land" => "Österreich"],
    ["Vorname" => "Sophie", "Nachname" => "Meier", "Land" => "Schweiz"],
    ["Vorname" => "Jonas", "Nachname" => "Huber", "Land" => "Deutschland"],
    ["Vorname" => "Laura", "Nachname" => "Bauer", "Land" => "Österreich"],
    ["Vorname" => "Tim", "Nachname" => "Keller", "Land" => "Schweiz"],
    ["Vorname" => "Mia", "Nachname" => "Fischer", "Land" => "Deutschland"],
    ["Vorname" => "Ben", "Nachname" => "Wolf", "Land" => "Österreich"],
    ["Vorname" => "Lea", "Nachname" => "Weber", "Land" => "Schweiz"],
    ["Vorname" => "Paul", "Nachname" => "Becker", "Land" => "Deutschland"],
];

// Filter & Sortierparameter
$filter = strtolower($_GET['filter'] ?? '');
$sortBy = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? 'asc';

// Filtern
$filteredData = array_filter($data, function ($row) use ($filter) {
    return $filter === '' ||
        str_contains(strtolower($row['Vorname']), $filter) ||
        str_contains(strtolower($row['Nachname']), $filter) ||
        str_contains(strtolower($row['Land']), $filter);
});

// Sortieren
if (in_array($sortBy, ['Vorname', 'Nachname', 'Land'])) {
    usort($filteredData, function ($a, $b) use ($sortBy, $order) {
        return $order === 'desc'
            ? strcmp($b[$sortBy], $a[$sortBy])
            : strcmp($a[$sortBy], $b[$sortBy]);
    });
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Personenliste</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            margin: auto;
            border-collapse: collapse;
            width: 60%;
            background: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        input[type="text"], select {
            padding: 8px;
            margin: 0 5px;
        }
        input[type="submit"] {
            padding: 8px 12px;
        }
    </style>
</head>
<body>
<h1>Personenliste</h1>
<form method="get">
    <input type="text" name="filter" placeholder="Suche nach Name oder Land" value="<?= htmlspecialchars($filter) ?>">
    <select name="sort">
        <option value="">Sortieren nach</option>
        <option value="Vorname" <?= $sortBy === 'Vorname' ? 'selected' : '' ?>>Vorname</option>
        <option value="Nachname" <?= $sortBy === 'Nachname' ? 'selected' : '' ?>>Nachname</option>
        <option value="Land" <?= $sortBy === 'Land' ? 'selected' : '' ?>>Land</option>
    </select>
    <select name="order">
        <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>Aufsteigend</option>
        <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Absteigend</option>
    </select>
    <input type="submit" value="Anwenden">
</form>

<table>
    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Land</th>
    </tr>
    <?php foreach ($filteredData as $person): ?>
        <tr>
            <td><?= htmlspecialchars($person['Vorname']) ?></td>
            <td><?= htmlspecialchars($person['Nachname']) ?></td>
            <td><?= htmlspecialchars($person['Land']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
