<?php
//als sessie niet gestart is start sessie
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controleer of gebruiker ingelogd is
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: src/php/login.php');
    exit();
}
$base = '/periode_1/gegevenssprint';

require_once(__DIR__ . '../php/hoofpaginabackend.php');
require_once(__DIR__ . '../php/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php echo $welcomeMessage; ?>
    <main class="main-center">
        <div class="centered-spin">
            <div class="draaiende-knop-container rotate-inner">
                <form action="" method="post">
                    <button type="submit" name="clickButton" id="e" class="btn upright">Click me!</button>
                    <?php echo "<p><span class='upright'>Button clicked " . htmlspecialchars($_SESSION['clicks']) . " times</span></p>"; ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>