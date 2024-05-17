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

// Get POST data
$team_id = $_POST['team_id'];

// Example compensatory pick calculation function
function calculateCompensatoryPicks($team_id) {
    global $conn;

    // Fetch all players marked as lost free agents for the team
    $sql = "SELECT * FROM players WHERE team_id = $team_id AND free_agent_status = 'lost'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    // Calculate the value based on the compensatory pick formula
    $compensatory_value = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Example formula based on player's salary and performance
            $compensatory_value += $row['salary'] * 0.1;  // Simplified example
        }
    }

    // Return the calculated compensatory picks value
    return $compensatory_value;
}

// Calculate compensatory picks
$compensatory_value = calculateCompensatoryPicks($team_id);
echo "Compensatory Value: $compensatory_value";

$conn->close();
?>

