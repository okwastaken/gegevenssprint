<?php
include '../../php/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//check of ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gebruikersnaam'])) {
    try {
        //check of gebruikersnaam al bestaat
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $id = $_SESSION['user_id'];

        $stmt2 = $conn->prepare("SELECT id FROM gebruikers WHERE naam = ? AND id != ?");
        $stmt2->bind_param('si', $gebruikersnaam, $id);
        $stmt2->execute();
        $stmt2->store_result();
        //als er al een user met die naam is dan toon error met js file
        if ($stmt2->num_rows > 0) {
            header('Location: ../veranderengebruikersnaampagina.php?error=username_taken');
        } else {
            //als er geen zelfde naam al bestaat update de naam naar nieuwe naam
            $stmt = $conn->prepare("UPDATE gebruikers SET naam = ? WHERE id = ?");
            $stmt->bind_param('si', $gebruikersnaam, $id);
            if ($stmt->execute()) {
                //update sessie gebruikersnaam om meteen de nieuwe naam te tonen
                $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                header('Location: ../account.php');
                //afsluiten
                exit;
            } else {
                //fout bericht
                echo '<div class="alert error">Fout bij bijwerken: ' . htmlspecialchars($stmt->error) . '</div>';
            }
        }
    } catch (Exception $e) {
        echo "Fout bij het bijwerken van de gebruikersnaam: " . $e->getMessage();
    } finally {
        $stmt->close();
        $stmt2->close();
    }
}
