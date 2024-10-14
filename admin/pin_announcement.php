<?php
include '../config.php'; // Ensure this points to your config file
session_start();

header('Content-Type: application/json');

// Check connection
$conn = $con; // Set $conn to the mysqli connection from config
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . mysqli_connect_error()]);
    exit();
}

// Handle POST request to pin announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the announcement ID from the request
    $data = json_decode(file_get_contents("php://input"), true);
    $announcementId = intval($data['id']); // Ensure it's an integer

    // Update the announcement to mark it as pinned
    $stmt = $conn->prepare("UPDATE announcements SET is_pinned = 1 WHERE id = ?");
    $stmt->bind_param("i", $announcementId);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["success" => "Announcement pinned successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error pinning announcement: " . $stmt->error]);
    }

    $stmt->close();
}
$conn->close();
?>
