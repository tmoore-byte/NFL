<?php
$servername = 'localhost';
$username = 'nfl_user';
$password = 'nfl_password';
$dbname = 'nfl_draft_trade';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo 'Connected successfully';
?>
