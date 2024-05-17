<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "nfl_user";
$password = "nfl_password";
$dbname = "nfl_draft_trade";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example player grading function with eye test score and consensus ranking
function calculatePlayerGrade($performance, $potential, $eye_test, $consensus_ranking) {
    // Adjust the weightings as necessary
    return ($performance * 0.4) + ($potential * 0.3) + ($eye_test * 0.2) + ($consensus_ranking * 0.1);
}

// Fetch player data
$sql = "SELECT player_id, performance, potential, eye_test_score, consensus_ranking FROM players";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $grade = calculatePlayerGrade(
            $row['performance'], 
            $row['potential'], 
            $row['eye_test_score'], 
            $row['consensus_ranking']
        );
        $update_sql = "UPDATE players SET grade = $grade WHERE player_id = " . $row['player_id'];
        if ($conn->query($update_sql) === FALSE) {
            echo "Error updating record for player_id " . $row['player_id'] . ": " . $conn->error . "<br>";
        } else {
            echo "Record updated for player_id " . $row['player_id'] . "<br>";
        }
    }
} else {
    echo "No players found in the database.";
}

$conn->close();
?>

