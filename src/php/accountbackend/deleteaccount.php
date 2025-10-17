<?php

require_once __DIR__ . '../../../../vendor/autoload.php';
//plugins voor loggen van account verwijdering
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

include '../php/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// controleer ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verwijder'])) {
    // sessie variabelen ophalen en default neerzetten bij leeftijd en clicks
    $id = $_SESSION['user_id'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $clicks = $_SESSION['clicks'] ?? 0;
    $leeftijd = $_SESSION['leeftijd'] ?? 18;

    $stmt = $conn->prepare("DELETE FROM gebruikers WHERE id = ?");
    $stmt->bind_param('i', $id);
    // voer de verwijdering uit
    if ($stmt->execute()) {
        // log de verwijdering van het account
        $log = new Logger('delete_account');
        //waar logfile staat
        $logFile = '../../log/info.log';
        // voeg handler toe
        $log->pushHandler(new StreamHandler($logFile, Level::Info));
        // info loggen zoals id, naam, leeftijd, clicks
        $log->info('deleted account id: ' . $id . ' gebruikersnaam ' .  $gebruikersnaam .
            ' Leeftijd: ' . $leeftijd . ' Clicks: ' . $clicks);
        //en uiteindelijk sessie vernietigen en doorsturen naar login
        session_unset();
        session_destroy();
        header('Location: ../php/login.php');
        //afsluiten
        exit;
    } else {
        //anders loggen van fout
        $log->debug('debug' . $id);
        $log->warning('geen gebruiker gevonden' . $id);
        $log->error('Dit is een error' . $stmt->error);
        echo '<div class="alert error">Fout bij het verwijderen van het account. Probeer het later opnieuw.</div>';
    }

    $stmt->close();
}
