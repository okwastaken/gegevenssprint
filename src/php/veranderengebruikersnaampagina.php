<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ../php/login.php');
    exit;
}

?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gebruikersnaam veranderen</title>
  <link rel="stylesheet" href="../css/verandergebruikersnaam.css">
</head>
<body>
  <div class="container page" id="username-page">
    <div class="header">
      <h1 id="page-title">Gebruikersnaam veranderen</h1>
    </div>

    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'username_taken') {
        echo '<div class="alert error" role="alert">Deze gebruikersnaam is al in gebruik.</div>';
    }
    if (isset($_GET['error']) && $_GET['error'] === 'invalid_length') {
        echo '<div class="alert error" role="alert">Gebruikersnaam moet tussen 3 en 50 tekens zijn.</div>';
    }
    ?>

    <form id="username-form" class="form" method="post" action="./accountbackend/updategebruikersnaam.php" aria-labelledby="page-title">
        <div class="form-row">
            <label for="gebruikersnaam">Nieuwe gebruikersnaam:</label>
            <input id="gebruikersnaam" name="gebruikersnaam" type="text" value="" required />
        </div>

        <div class="form-actions">
            <button id="btn-save-username" class="btn" type="submit" name="opslaan">Opslaan</button>
            <button id="btn-cancel-username" class="btn ghost" type="button" onclick="location.href='account.php'">Annuleren</button>
        </div>
    </form>
  </div>
  <script src="../js/confirm.js"></script>
</body>
</html>
