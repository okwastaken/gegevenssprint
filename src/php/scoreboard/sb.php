<?php
include __DIR__ . '../../db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}

$button = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['scores'])) {
        $stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();

        $button .= "<h2>Scoreboard</h2>";
        $button .= "<table border='1'>";
        $button .= "<tr><th>Positie</th><th>Naam</th><th>Clicks</th></tr>";

        $positie = 1;
        while ($row = $result->fetch_assoc()) {
            $rowClass = '';
            if ($positie == 1) $rowClass = 'top-1';
            elseif ($positie == 2) $rowClass = 'top-2';
            elseif ($positie == 3) $rowClass = 'top-3';

            $button .= "<tr class='" . $rowClass . "'>";
            $button .= "<td>" . $positie . "</td>";
            $button .= "<td>" . htmlspecialchars($row['naam']) . "</td>";
            $button .= "<td>" . htmlspecialchars($row['clicks']) . "</td>";
            $button .= "</tr>";
            $positie++;
        }

        $button .= "</table>";
    }
    
}

echo $button;
?>
