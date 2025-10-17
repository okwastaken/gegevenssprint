<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'header.php';
include "./clicks/scores.php";
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}
$base = '../../';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <link rel="stylesheet" href="../css/pdf.css">
    <link rel="stylesheet" href="../css/scores.css">

</head>

<body>
    <div class="account-container">

        <!-- Only include sb.php for the scoreboard table -->
        <?php include './scoreboard/sb.php'; ?>

        <!-- PDF button below the scoreboard -->
        <div class="pdf-container">
            <form method="post" action="./scoreboard/pdfback.php" target="_blank">
                <button type="submit" name="download_pdf">Download leaderboard als PDF</button>
            </form>
        </div>
    </div>
</body>

</html>