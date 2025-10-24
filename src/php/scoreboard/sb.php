<?php
include __DIR__ . '../../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: ../php/login.php');
    exit();
}

$gebruiker = $_SESSION['gebruikersnaam'];
$button = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("SELECT naam, clicks FROM gebruikers ORDER BY clicks DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();

        $button .= "<div class='wrapper'>";
        $button .= "<h1>Leaderboard</h1>";
        $button .= "<table class='leaderboard'>";
        $button .= "<thead>
                        <tr>
                            <th>Positie</th>
                            <th>Naam</th>
                            <th>Clicks</th>
                        </tr>
                    </thead>";
        $button .= "<tbody>";

        $positie = 1;
        while ($row = $result->fetch_assoc()) {
            $naam = htmlspecialchars($row['naam']);
            $clicks = htmlspecialchars($row['clicks']);

            // als naam gelijk is aan huidige gebruiker, andere class toevoegen om user te highlighten
            if ($naam === $gebruiker) {
                $row = 'current-user';
            }

            $button .= '<tr class="' . $row . '">';
            $button .= '<td>' . $positie . '</td>';
            $button .= '<td>' . $naam . '</td>';
            $button .= '<td class="clicks">' . $clicks . '</td>';
            $button .= "</tr>";
            $positie++;
        }

        $button .= "</tbody>
                    </table>
                    </div>";
        echo $button;
    } catch (Exception $e) {
        echo "Fout bij het ophalen van de scoreboard: " . $e->getMessage();
    } finally {
        $stmt->close();
    }
}
