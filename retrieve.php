<?php
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

$sql = "SELECT * FROM players";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["player_id"]. " - Name: " . $row["name"]. " - Position: " . $row["position"]. " - Team: " . $row["team"]. " - Stats: " . $row["stats"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

