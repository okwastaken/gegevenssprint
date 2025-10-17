<?php
session_start();
include __DIR__ . '/../db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naam = htmlspecialchars($_POST['gebruikersnaam']);
    $leeftijd = htmlspecialchars($_POST['leeftijd']);


    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE naam = ? AND leeftijd = ?");
    $stmt->bind_param("si", $naam, $leeftijd);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['gebruikersnaam'] = $row['naam'];
            $_SESSION['leeftijd'] = $row['leeftijd'];
            $_SESSION['is_admin'] = $row['is_admin'];
            header("Location: ../../index.php");
            exit();
        } else {
            header("Location: ../login.php?error=invalid_login");
            exit;
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
