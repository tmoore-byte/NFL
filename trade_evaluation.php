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
$team_from = $_POST['team_from'];
$team_to = $_POST['team_to'];
$player_ids = $_POST['player_ids'];
$draft_picks = $_POST['draft_picks'];

// Example trade evaluation function
function evaluateTrade($team_from, $team_to, $player_ids, $draft_picks) {
    global $conn;

    // Fetch player grades and calculate total player value for the trade
    $player_value = 0;
    $player_ids_array = explode(',', $player_ids);
    foreach ($player_ids_array as $player_id) {
        $player_sql = "SELECT grade FROM players WHERE player_id = $player_id";
        $player_result = $conn->query($player_sql);
        if ($player_result->num_rows > 0) {
            $player_row = $player_result->fetch_assoc();
            $player_value += $player_row['grade'];
        }
    }

    // Calculate draft pick value (simplified example, adjust as necessary)
    $draft_pick_value = count(explode(',', $draft_picks)) * 10;

    // Calculate total trade value score
    $trade_value_score = $player_value + $draft_pick_value;

    // Insert trade evaluation into trades table
    $trade_sql = "INSERT INTO trades (team_from, team_to, player_ids, draft_picks, trade_value_score, trade_date)
                  VALUES ($team_from, $team_to, '$player_ids', '$draft_picks', $trade_value_score, CURDATE())";
    if ($conn->query($trade_sql) === FALSE) {
        echo "Error inserting trade record: " . $conn->error . "<br>";
    } else {
        echo "Trade record inserted successfully.<br>";

