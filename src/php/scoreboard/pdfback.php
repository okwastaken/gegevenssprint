<?php
require_once __DIR__ . '../../db.php';
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
//voor later gebruik in de while loop om top 10 te displayen
$positie = 1;
$top10 = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_pdf'])) {

    // Haal data op
    $stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC limit 10");
    $stmt->execute();
    $result = $stmt->get_result();

    $html = '<!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="utf-8">
        <title>Leaderboard</title>
        <style>
            /* --------------------------------heb het hier gedaan omdat ik niet zeker weet of de cache tegen werkt of css gewoon hierneergezetmoet worden*/
            @page { margin: 18mm 15mm; size: A4 portrait; }
            html, body {
                margin: 0;
                padding: 0;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
                color: #222;
                background: #fff;
            }
            .wrapper {
                padding: 0mm; /* @page marge regelt de pagina marges */
                width: 100%;
            }

            h1 {
                margin: 0 0 12px 0;
                padding: 6px 0;
                font-size: 20px;
                font-weight: 700;
                text-align: center;
                color: #0f172a;
            }

            /* Tabel */
            table.leaderboard {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
                word-wrap: break-word;
                margin-top: 6px;
            }
            table.leaderboard thead th {
                padding: 10px 12px;
                text-align: left;
                font-weight: 700;
                font-size: 13px;
                background-color: #2b7ed6;
                color: #ffffff;
                border: 1px solid rgba(0,0,0,0.06);
            }
            table.leaderboard tbody td {
                padding: 10px 12px;
                border: 1px solid rgba(0,0,0,0.06);
                vertical-align: middle;
                font-size: 13px;
                white-space: nowrap; /* zet op normal als je wil dat namen mogen wrappen */
                overflow: hidden;
                text-overflow: ellipsis;
            }
            /* clicks kolom */
            table.leaderboard tbody td.clicks {
                text-align: right;
                font-weight: 700;
                width: 110px;
            }

            /* Zebra */
            table.leaderboard tbody tr:nth-child(even) td {
                background-color: #fbfdff;
            }

            /* Top 3 accenten via classes (gemakkelijk en betrouwbaar) */
            tr.top-1 td { background-color: #fff7e6; } /* licht goud */
            tr.top-2 td { background-color: #f2fbff; } /* licht zilver/blauw */
            tr.top-3 td { background-color: #fff5f9; } /* licht brons/roze */

            /* Medailles als pseudo-elementen worden niet betrouwbaar geprint door Dompdf,
               dus voegen we de emoji direct in de content (in PHP). */

            /* Print-vriendelijke regels */
            @media print {
                h1 { font-size: 18px; text-align: left; padding: 4px 0; }
                table.leaderboard thead th, table.leaderboard tbody td { padding: 8px; font-size: 12px; }
                tr, td, th { page-break-inside: avoid; }
            }

            /* Kleine weergave voor smalle schermen (alleen relevant bij schermweergave, niet voor PDF) */
            @media screen and (max-width: 520px) {
                table.leaderboard thead { display: none; }
                table.leaderboard, table.leaderboard tbody, table.leaderboard tr, table.leaderboard td { display: block; width: 100%; }
                table.leaderboard tr { margin-bottom: 10px; }
                table.leaderboard td { white-space: normal; }
                table.leaderboard td.clicks { text-align: left; }
            }
        </style>
        
    </head>
    <body>
    <div class="wrapper">
        <h1>Leaderboard</h1>
        <table class="leaderboard">
            <thead>
                <tr>
                <th>Positie</th>
                <th>Naam</th>
                <th style="text-align:right;width:110px;">Clicks</th>
                </tr>
            </thead>
            <tbody>';


    while ($row = $result->fetch_assoc()) {
    //haal de naam en clicks op
    $naam = htmlspecialchars($row['naam']);
    $clicks = htmlspecialchars($row['clicks']);

    // top 3 styling zoals bij scoreboard pagina
    $row = '';
    if ($positie == 1) $row = 'top-1';
    elseif ($positie == 2) $row = 'top-2';
    elseif ($positie == 3) $row = 'top-3';
    // rest van de rijen
    $html .= '<tr class="' . $rowClass . '">';
    $html .= '<td>'  . $positie . '</td>';
    $html .= '<td>'  . $naam . '</td>';
    $html .= '<td class="clicks">' . $clicks . '</td>';
    $html .= '</tr>';
    $positie++;
    }

    $html .= '</tbody></table>
    </div>
    </body>
    </html>';

    // genereer PDF en stuur naar browser
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('leaderboard.pdf', ['Attachment' => 1]); // forceer download
    // afsluiten
    exit();
}
