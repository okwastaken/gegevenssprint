<?php
session_start();
include __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //htmlspecialchars om XSS te voorkomen
    $naam = htmlspecialchars($_POST['gebruikersnaam']);
    $leeftijd = htmlspecialchars($_POST['leeftijd']);


    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE naam = ? AND leeftijd = ?");
    $stmt->bind_param("si", $naam, $leeftijd);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        //als gebruiker bestaat dan stuurt 
        // error als ongeldige login die verder
        //afgehandeld wordt in confirm.js voor error bericht
        if ($result->num_rows > 0) {
            // haal user data op als login succesvol is
            $row = $result->fetch_assoc();
            // sla gegevens op in sessie
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['gebruikersnaam'] = $row['naam'];
            $_SESSION['leeftijd'] = $row['leeftijd'];
            $_SESSION['is_admin'] = $row['is_admin'];
            // doorsturen naar hoofdpagina en afsluiten
            header("Location: ../../index.php");
            exit();
        } else {
            //anders doorsturen met error
            header("Location: ../login.php?error=invalid_login");
            exit;
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
