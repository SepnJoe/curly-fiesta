<!-- Titel:
     Autor: Feldinger Niklas
     Datum:  -->

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Raiffeisen Login</title>
    <link rel="stylesheet" href="styling.css">
</head>
<div class="container">
    <header>
        <hr>
        <h1> <img src="assets/logo.png" alt="Logo" class="logo"> Raiffeisen Login</h1>

        <hr>
    </header>

    <main>
        <div>
            <form action="login.php" method="post">
                <label for="Feld_username">Username</label>
                <input name="username" type="text" required class="input-field"
                    value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
                <br>
                <label for="Feld_Password">Password</label>
                <input name="password" type="password" required class="input-field" style="margin-left: 5px;">
                <br>
                <br>
                <input type="submit" value="Login">
                <input type="reset" value="Clear">
            </form>
        </div>
        <hr>
        <p><a href="registerFormular.html">Noch kein Konto?</a></p>
        <p><a href="landingPage.php">Zum Produkt</a></p>
    </main>
</div>

</html>