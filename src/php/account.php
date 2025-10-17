<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}

require_once('header.php');
?>

<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Account</title>
    <link rel="stylesheet" href="../css/acount.css">
</head>

<body>
    <div class="account-container">
        <h1>Accountpagina</h1>
        <p>Welkom, <strong><?= htmlspecialchars($_SESSION['gebruikersnaam']) ?></strong>!</p>

        <?php
        require_once('./accountbackend/displayacc.php');
        require_once('./accountbackend/resetclicks.php');
        require_once('./accountbackend/deleteaccount.php');
        ?>

        <div class="button-group">
            <form method="post" action="veranderengebruikersnaampagina.php">
                <button type="submit">Gebruikersnaam veranderen</button>
            </form>

            <form method="post" action="">
                <button type="submit" name="clicks">Reset clicks</button>
            </form>

            <form method="post" action="">
                <button type="submit" name="verwijder">Verwijder account</button>
            </form>
        </div>
    </div>
    <script src="../js/confirm.js"></script>
</body>

</html>
