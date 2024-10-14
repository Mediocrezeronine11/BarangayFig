<?php
// fetch_taken_positions.php
session_start();
include 'config.php'; // Ensure this file contains your database connection

// Fetch taken positions from the database
$query = "SELECT position FROM tblaccounts WHERE position IS NOT NULL";
$result = mysqli_query($con, $query);

$takenPositions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $takenPositions[] = $row['position'];
}

// Return the positions as a JSON array
header('Content-Type: application/json');
echo json_encode($takenPositions);
?>
