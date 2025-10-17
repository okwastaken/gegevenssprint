<?php
include '../php/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_admin']) === 1) {
    header('Location: ../php/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("SELECT * FROM gebruikers");

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<div class="table-container">';
            echo "<table>";
            echo "  <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Leeftijd</th>
                    <th>Clicks</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>";

            while ($row = $result->fetch_assoc()) {
                $is_admin = ($row['is_admin'] == 1) ? "Ja" : "Nee";

                echo "<tr>
                    <td data-label='ID'>" . htmlspecialchars($row['id']) . "</td>
                    <td data-label='Naam'>" . htmlspecialchars($row['naam']) . "</td>
                    <td data-label='Leeftijd'>" . htmlspecialchars($row['leeftijd']) . "</td>
                    <td data-label='Clicks'>" . htmlspecialchars($row['clicks']) . "</td>
                    <td data-label='Admin'>" . $is_admin . "</td>
                </tr>";
            }

            echo "</tbody></table>";
            echo "</div>";
        } else {
            echo "Geen gebruikers gevonden.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}

$button = '<form action="" method="post">
<button type="submit">Toon gebruikers</button>
</form>';
