<?php

require_once __DIR__ . '../../../../vendor/autoload.php';

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

    $id = $_SESSION['user_id'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $clicks = $_SESSION['clicks'] ?? 0;
    $leeftijd = $_SESSION['leeftijd'] ?? 18;

    $stmt = $conn->prepare("DELETE FROM gebruikers WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $log = new Logger('delete_account');
        $logFile = '../../log/info.log';

        $log->pushHandler(new StreamHandler($logFile, Level::Info));
        $log->info('deleted account id: ' . $id . ' gebruikersnaam ' .  $gebruikersnaam .
            ' Leeftijd: ' . $leeftijd . ' Clicks: ' . $clicks);

        session_unset();
        session_destroy();
        header('Location: ../php/login.php');

        exit;
    } else {
        $log->debug('debug' . $id);
        $log->warning('geen gebruiker gevonden' . $id);
        $log->error('Dit is een error' . $stmt->error);
        echo '<div class="alert error">Fout bij het verwijderen van het account. Probeer het later opnieuw.</div>';
    }

    $stmt->close();
}
