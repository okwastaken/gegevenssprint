<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
//dotenv laden voor veilige verbinding met database
$host = $_ENV['DB_HOST'];
$naam = $_ENV['DB_USER'];
$wachtwoord = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

try {
    $conn = new mysqli($host, $naam, $wachtwoord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
