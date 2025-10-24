<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_excel'])) {
    try {
        //maak nieuw spreadsheet aan
        $spreadsheet = new Spreadsheet();
        //active sheet selecteren
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Positie');
        $sheet->setCellValue('B1', 'Naam');
        $sheet->setCellValue('C1', 'Clicks');

        // Data ophalen
        $stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();

        $rowNumber = 2;
        $positie = 1;

        while ($row = $result->fetch_assoc()) {
            // regels breedte van a tot c vullen met de positie en naam en clicks per user
            $sheet->setCellValue('A' . $rowNumber, $positie);
            $sheet->setCellValue('B' . $rowNumber, $row['naam']);
            $sheet->setCellValue('C' . $rowNumber, $row['clicks']);
            $rowNumber++;
            $positie++;
        }

        // Stuur naar browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="leaderboard.xlsx"');
        header('Cache-Control: max-age=0');
        // Schrijf bestand naar output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    } catch (Exception $e) {
        echo "Fout bij het genereren van het Excel-bestand: " . $e->getMessage();
    } finally {
        $stmt->close();
    }
    exit();
}
