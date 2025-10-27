<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}
require_once('header.php');
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>

    <link rel="stylesheet" href="../css/test.css">

</head>

<body>


    <div class="account-container">
        <?php include './scoreboard/sb.php'; ?>

        <div class="button-group">
            <form method="post">
                <button type="submit" name="scores">Toon scoreboard</button>
            </form>
            <form method="post" action="./scoreboard/excel.php" target="_blank" class="xlsx-container">
                <button type="submit" name="download_excel">Download leaderboard als .XLSX</button>
            </form>

            <form method="post" action="./scoreboard/pdfback.php" target="_blank" class="pdf-container">
                <button type="submit" name="download_pdf">Download leaderboard als .PDF</button>
            </form>
        </div>
    </div>
</body>
</body>

</html>