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
try {
    $id = $_SESSION['user_id'];
    $naam = $_SESSION['gebruikersnaam'];

    $stmt = $conn->prepare("SELECT id, naam, leeftijd, clicks FROM gebruikers WHERE id  = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // toon gebruikers leeftijd en clicks
        while ($row = $result->fetch_assoc()) {

            echo
            "  Leeftijd: " . htmlspecialchars($row["leeftijd"]) . "<br>"
                . "  Clicks: " . htmlspecialchars($row["clicks"]) . "<br>";
        }
    } else {
        // geen resultaten bericht
        echo '<div class="card-note">Geen resultaten voor gebruiker: ' . htmlspecialchars($naam) . '</div>';
    }
} catch (Exception $e) {
    echo "Fout bij het ophalen van accountgegevens: " . $e->getMessage();
} finally {
    $stmt->close();
}
