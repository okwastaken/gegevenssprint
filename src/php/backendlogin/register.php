<?php
include __DIR__ . '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        //htmlspecialchars om XSS te voorkomen 
        $naam = htmlspecialchars($_POST['gebruikersnaam']);
        $leeftijd = htmlspecialchars($_POST['leeftijd']);

        // Check of naam al bestaat
        $stmt2 = $conn->prepare("SELECT id FROM gebruikers WHERE naam = ?");
        $stmt2->bind_param('s', $naam);
        $stmt2->execute();
        //voor check of er al een user met zelfde naam inzit
        $stmt2->store_result();
        //voor check of er al een user met zelfde naam inzit
        if ($stmt2->num_rows > 0) {
            header('Location: ../registerform.php?error=username_taken');
            exit();
        }
        //afsluiten check
        $stmt2->close();
        // Voeg nieuwe gebruiker toe
        $stmt = $conn->prepare("INSERT INTO gebruikers (naam, leeftijd) VALUES (?, ?)");
        $stmt->bind_param("si", $naam, $leeftijd);
        if ($stmt->execute()) {
            header("Location: ../login.php?registered=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        // afsluiten
        $stmt->close();
    } catch (Exception $e) {
        echo "Fout bij het verwerken van de registratie: " . $e->getMessage();
        header('location: ../registerform.php');
    }
}
