<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//had problemen met directory en heb het hierbij ge hardforceert
$base = 'gegevenssprint/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $base ?>../css/header.css">
    <link rel="stylesheet" href="<?= $base ?>../../css/header.css">
</head>

<body>
    <header>

        <nav class="navbar">
            <img src="../../resources/add-6622547_1280.png" alt="logo" class="draaiendefoto">
            <button class="hamburger" aria-label="Menu" aria-expanded="false" aria-controls="navmenu">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect y="7" width="32" height="4" rx="2" fill="white" />
                    <rect y="14" width="32" height="4" rx="2" fill="white" />
                    <rect y="21" width="32" height="4" rx="2" fill="white" />
                </svg>
            </button>
            <ul id="navmenu">
                <li><a href="/gegevenssprint/src/index.php">Home</a></li>
                <?php
                if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                    echo '<li><a href="/gegevenssprint/src/php/admin.php">Admin Paneel</a></li>';
                }
                ?>
                <li><a href="/gegevenssprint/src/php/scoreboard.php">Scoreboard</a></li>
                <li><a href="/gegevenssprint/src/php/account.php">Account</a></li>
                <li><a href="/gegevenssprint/src/php/logout.php" id="weetjehetzeker">Afmelden</a></li>
            </ul>
        </nav>
    </header>

    <script>
        // bevestiging afmelden
        document.addEventListener('DOMContentLoaded', () => {
            const zekerLinks = document.querySelectorAll('a#weetjehetzeker');
            zekerLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!confirm('Weet je zeker dat je deze actie wilt uitvoeren?')) {
                        e.preventDefault();
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navmenu = document.getElementById('navmenu');

            function showMenu(show) {
                if (show) {
                    navmenu.classList.add('open');
                } else {
                    navmenu.classList.remove('open');
                }
            }

            hamburger.addEventListener('click', function() {
                const expanded = hamburger.getAttribute('aria-expanded') === 'true';
                hamburger.setAttribute('aria-expanded', !expanded);
                showMenu(!expanded);
            });

            function handleResize() {
                if (window.innerWidth <= 600) {
                    showMenu(false);
                    hamburger.style.display = 'flex';
                } else {
                    showMenu(true);
                    hamburger.style.display = 'none';
                }
            }
            window.addEventListener('resize', handleResize);
            handleResize();
        });
    </script>
</body>

</html>