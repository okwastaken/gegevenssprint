<?php
// Start session EERST
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check of gebruiker ingelogd is
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}
// Check of gebruiker admin is - GEFIXED: correcte logica
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../php/login.php");
    exit();
}

$welkom = "Welkom " . htmlspecialchars($_SESSION['gebruikersnaam']) . " op de admin pagina! Hier zie je de gebruikers, hun leeftijd en username!";


require_once('header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneel</title>

    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
   <main class="admin-page container">
        <h1 class="page-title"><?= $welkom ?></h1>

        <div class="animatiekleur">Admin Paneel</div>

        <?php
       //userlist
        require_once './adminbackend/userlist.php';

        // echo button als die bestaat
        if (!empty($button)) {
            echo $button;
        }
        ?>
    </main>
</body>

</html>