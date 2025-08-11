# LAP
- Xampp
- mysql workbench
- Visual Studio Code 
- - PHP Intelephense
- zusammenfassung (Scs)
- eventuell DB Informationen als Enum?


# XAMPP
1. landingPage.php
2. styling.css
3. loginPage.php
4. registerFormular.html


AutoFormat VS-code
Alt + shift + F

<p><strong>Geburtstag:</strong> <?= $geburtstag ? date_format($geburtstag, "Y-m-d") : '' ?></p>


buttons einzeln
<div class="profil">
    <div><a class="editButton" href="feldBearbeiten.php?feld=Anrede"><strong>Anrede:</strong> <?= htmlspecialchars($anrede) ?></a></div>
    <div><a class="editButton" href="feldBearbeiten.php?feld=Vorname"><strong>Vorname:</strong> <?= htmlspecialchars($vorname) ?></a></div>
    <div><a class="editButton" href="feldBearbeiten.php?feld=Nachname"><strong>Nachname:</strong> <?= htmlspecialchars($nachname) ?></a></div>
    <div><a class="editButton" href="feldBearbeiten.php?feld=Geburtstag"><strong>Geburtstag:</strong> <?= htmlspecialchars($geburtstag) ?></a></div>
    <div><a class="editButton" href="feldBearbeiten.php?feld=Strasse"><strong>Strasse:</strong> <?= htmlspecialchars($strasse) ?></a></div>
    <div><a class="editButton" href="feldBearbeiten.php?feld=Hausnummer"><strong>Hausnummer:</strong> <?= htmlspecialchars($hausnummer) ?></a></div>
</div>