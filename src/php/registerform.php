<?php require './backendlogin/register.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login_register.css">
</head>

<body>
    <div class="container">
        <form action="backendlogin/register.php" method="post">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'username_taken') {
                echo '<p style="color:red;">Deze gebruikersnaam is al in gebruik.</p>';
            }
            ?>
            <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" required>
            <input type="number" name="leeftijd" placeholder="leeftijd(max 120)" required min="18" max="120">
            <div class="form-actions">
                <button class="btn" type="submit">registreren</button>
                <a class="btn" href="./login.php">Heb je al een account?</a>
            </div>
        </form>
    </div>
</body>

</html>