<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// als gebruker geen admin is:
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] === 0) {
    header('location: ../logout.php');
    exit('Toegang geweigerd.');
}
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../db.php';

use Spatie\DbDumper\Databases\MySql;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Maak tijdelijk bestand in dezelfde map
    $filename = 'backup' . date('Y-m-d_H-i-s') . '.sql';
    $tmpFile =  '../' . $filename;
    try {
        // Dump naar een echt bestand (Windows werkt niet met php://output)
        MySql::create()
            ->setHost($host)
            ->setDbName($database)
            ->setUserName($naam)
            ->setPassword($wachtwoord)
            ->includeTables(['gebruikers'])
            ->setDumpBinaryPath('C:\\MAMP\\bin\\mysql\\bin') // pad naar map met mysqldump.exe
            ->dumpToFile($tmpFile);

        // Stuur bestand naar browser
        header('Content-Type: application/sql; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tmpFile));
        readfile($tmpFile);
    } catch (Exception $e) {
        $e->getMessage();
    } finally {
        // Verwijder tijdelijk bestand
        unlink($tmpFile);
    }
    exit;
}
