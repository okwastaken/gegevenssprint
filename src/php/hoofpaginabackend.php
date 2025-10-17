<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}

include 'db.php';

if (!isset($_SESSION['clicks'])) {
    $stmt = $conn->prepare("SELECT clicks FROM gebruikers WHERE naam = ?");
    $stmt->bind_param("s", $_SESSION['gebruikersnaam']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        //clicks omzetten naar integer
        $_SESSION['clicks'] = (int)$row['clicks'];
    } else {
        $_SESSION['clicks'] = 0;
    }
    $stmt->close();
}

$welcomeMessage = "<h1 class='e'>Hallo " . htmlspecialchars($_SESSION['gebruikersnaam']) . "!<br></h1>";

// Verwerk click button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clickButton'])) {
        $_SESSION['clicks']++;

        // Update database
        $stmt = $conn->prepare("UPDATE gebruikers SET clicks = ? WHERE naam = ?");
        $stmt->bind_param("is", $_SESSION['clicks'], $_SESSION['gebruikersnaam']);
        $stmt->execute();
        $stmt->close();

        // Redirect om dubbele POST te voorkomen
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>