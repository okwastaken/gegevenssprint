<?php require_once('./backendlogin/backendlogin.php'); ?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login_register.css">
</head>

<body>

    <div class="container">
        <h1 class="page-title">Login</h1>
        <form action="./backendlogin/backendlogin.php" method="post">
            <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam">
            <input type="number" name="leeftijd" placeholder="leeftijd" min="18" max="120">
            <div class="form-actions">
                <button class="btn" type="submit">Login</button>
                <a class="btn" href="./registerform.php">Nog geen account?</a>
            </div>
        </form>
    </div>
</body>

</html>