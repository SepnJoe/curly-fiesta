<!-- HTML CSS PHP - Titel
     Autor: Feldinger Niklas
     Datum: 03.06.2025 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styling.css">
    <title>Raiffeisen Produkt</title>
</head>
<div class="container">
<header>
    <h1>Raiffeisen Produkt</h1>
    <img src="assets/logo.png" alt="Logo" class="logo">
    <br>
    <?php
    if (isset($_SESSION["username"])) {
        echo '<a href="logout.php" style="margin-left: 20px">Logout</a>';
        echo '<a href="profil.php" style="margin-left: 20px">Profil</a>';
    } else {
        echo '<a href="loginPage.php" style="margin-left: 20px">Login</a>';
        echo '<a href="monitoring.php" style="margin-left: 20px">Monitoring</a>';
    }
    ?>
</header>
<br>
<hr>
<p>Das Produkt ist ein Konto</p>
<img src="assets/sparkonto.jpg" alt="Sparkonto" class="logo">

<footer>
    <span>0.000% Zinsen<br></span>
</footer>
</div>
</html>
