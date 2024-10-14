<?php
include 'config.php';

// Query to fetch taken positions from the database
$query = "SELECT position FROM tblaccounts WHERE position IS NOT NULL AND user_type = 'official'";
$result = mysqli_query($con, $query);

$taken_positions = [];

while ($row = mysqli_fetch_assoc($result)) {
    $taken_positions[] = $row['position']; // Add the positions to the array
}

// Return the taken positions as JSON
echo json_encode($taken_positions);
?>
