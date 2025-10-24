<?php
require_once '../db.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use Dompdf\Dompdf;

//gebruik Dompdf plugin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//check of gebruiker ingelogd is
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}

$gebruiker = $_SESSION['gebruikersnaam'];
//voor later gebruik in de while loop om top 10 te displayen
$positie = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_pdf'])) {
    try {
        // Haal data op
        $stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC limit 10");
        $stmt->execute();
        $result = $stmt->get_result();
        $css = file_get_contents(__DIR__ . '/../../css/pdf.css');

        $html = '<!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="utf-8">
        <title>Leaderboard</title>
        <style>' . $css . '</style>
    </head>
    <body>
    <div class="wrapper">
        <h1>Leaderboard</h1>
        <table class="leaderboard">
            <thead>
                <tr>
                <th>Positie</th>
                <th>Naam</th>
                <th>Clicks</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = $result->fetch_assoc()) {
            //haal de naam en clicks op
            $naam = htmlspecialchars($row['naam']);
            $clicks = htmlspecialchars($row['clicks']);

            if ($naam === $gebruiker) {
                $row = 'current-user';
            }

            $html .= '<tr class="' . $row . '">';
            $html .= '<td>' . $positie . '</td>';
            $html .= '<td>' . $naam . '</td>';
            $html .= '<td class="clicks">' . $clicks . '</td>';
            $html .= '</tr>';
            $positie++;
        }

        $html .= '</tbody>
                  </table>
                  </div>
                  </body>
                  </html>';

        // genereer PDF en stuur naar browser
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('leaderboard.pdf', ['Attachment' => 1]); // forceer download
    } catch (Exception $e) {
        echo "Fout bij het genereren van PDF: " . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        exit();
    }
}
