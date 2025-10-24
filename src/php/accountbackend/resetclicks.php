<?php

include '../php/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// controleer ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../login.php');
    exit;
}

//isset post clicks voor resetten clicks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clicks'])) {
    try {

        $stmt = $conn->prepare("UPDATE gebruikers SET clicks = 0 WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Reset clicks in session 
            $_SESSION['clicks'] = 0 ?? 0;
            header('Location: ../php/account.php');
            exit;
        } else {
            //fout bericht
            echo "Fout bij resetten van clicks: " . htmlspecialchars($stmt->error);
        }
    } catch (Exception $e) {
        echo "Fout bij het resetten van clicks: " . $e->getMessage();
    } finally {
        $stmt->close();
    }
}
