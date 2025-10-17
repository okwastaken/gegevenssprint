<?php
include __DIR__ . '../../db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../login.php');
    exit();
}
$gebruiker = $_SESSION['gebruikersnaam'];
$clicks = null;

//clicks van gebruiker ophalen
$stmt = $conn->prepare("SELECT clicks FROM gebruikers WHERE naam = ?");
if ($stmt) {
    $stmt->bind_param("s", $gebruiker);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (isset($row['clicks'])) {
        $_SESSION['clicks'] = $row['clicks'];
        $clicks = $row['clicks'];
    }
    $stmt->close();
}


// top 10
$stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC LIMIT 10");
$stmt->execute();
$result = $stmt->get_result();

echo "<div class='scoreboard'>";
echo "<h2 class='scoreboard__title'>welkom hier staat uw ranking met clicks:</h2>";
echo "<table class='scoreboard__table' border='1'>";
echo "<thead class='scoreboard__head'><tr class='scoreboard__headrow'><th class='scoreboard__th'>Positie</th><th class='scoreboard__th'>Naam</th><th class='scoreboard__th'>Clicks</th></tr></thead>";
echo "<tbody class='scoreboard__body'>";

$positie = 1;
$inTop10 = false;

while ($row = $result->fetch_assoc()) {
    //als er niks is zet basis waarde 
    $naam   = isset($row['naam']) ? $row['naam'] : 'Onbekend';
    $click = isset($row['clicks']) ? $row['clicks'] : 0;

    if ($naam === $gebruiker) {
        $inTop10 = true;
        $clicks = $click;
        echo "<tr class='scoreboard__row scoreboard__row--current'>";
    } else {
        echo "<tr class='scoreboard__row'>";
    }

    echo "<td class='scoreboard__cell scoreboard__cell--positie'>" . $positie . "</td>";
    echo "<td class='scoreboard__cell scoreboard__cell--naam'>" . htmlspecialchars($naam) . "</td>";
    echo "<td class='scoreboard__cell scoreboard__cell--clicks'>" . htmlspecialchars($click) . "</td>";
    echo "</tr>";

    $positie++;
}
echo "</tbody>";
echo "</table>";

$stmt->close();



echo "</div>";
