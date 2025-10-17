<?php
include '../../php/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gebruikersnaam'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $id = $_SESSION['user_id'];

    $stmt2 = $conn->prepare("SELECT id FROM gebruikers WHERE naam = ? AND id != ?");
    $stmt2->bind_param('si', $gebruikersnaam, $id);
    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {
     header('Location: ../veranderengebruikersnaampagina.php?error=username_taken');
    } else {
        $stmt = $conn->prepare("UPDATE gebruikers SET naam = ? WHERE id = ?");
        $stmt->bind_param('si', $gebruikersnaam, $id);
        if ($stmt->execute()) {
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            header('Location: ../account.php');
            exit;
        } else {
          echo '<div class="alert error">Fout bij bijwerken: ' . htmlspecialchars($stmt->error) . '</div>';
        
        }
        $stmt->close();
    }

    $stmt2->close();
}

?>