<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}

// Display Bootstrap toast alert if session status is set
if (isset($_SESSION['status'])) {
    $alertType = $_SESSION['status_type'] ?? 'danger'; 

    // Bootstrap toast alert
    echo '<div class="position-fixed end-0 p-3 " style="z-index: 11; top: 10px; ">'; // Right side, with spacing from top and right
    echo '<div class="toast show align-items-center text-white bg-' . $alertType . ' border-0" role="alert" aria-live="assertive" aria-atomic="true">';
    echo '<div class="d-flex">';
    echo '<div class="toast-body">';
    echo $_SESSION['status'];
    echo '</div>';
    echo '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // Clear session variables
    unset($_SESSION['status']);
    unset($_SESSION['status_type']);
}

include '../config.php'; // Ensure this is correctly pointing to your config file

// Set content type to JSON initially
header('Content-Type: application/json');

// Use the existing $con variable for the connection
$conn = $con; // Set $conn to the mysqli connection from config

// Check connection
if (!$conn) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Connection failed: " . mysqli_connect_error()]);
    exit();
}

// Fetch pinned announcements if a GET request is made with 'pinned' parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pinned'])) {
    $query = "SELECT * FROM announcements WHERE is_pinned = 1 ORDER BY id DESC"; // Fetch pinned announcements
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $pinnedAnnouncements = [];
        while ($row = $result->fetch_assoc()) {
            $pinnedAnnouncements[] = $row; // Collect all rows in an array
        }
        echo json_encode($pinnedAnnouncements);
    } else {
        echo json_encode([]); // Return empty array if no pinned announcements found
    }
    $conn->close();
    exit();
}

// Fetch announcements if a GET request is made
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT * FROM announcements ORDER BY id DESC"; // Fetch announcements, latest first
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $announcements = [];
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row; // Collect all rows in an array
        }
        echo json_encode($announcements);
    } else {
        echo json_encode([]); // Return empty array if no announcements found
    }
    $conn->close();
    exit();
}

// Check if the form is submitted for announcements
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_GET['delete'])) {
    // Handle announcement text input
    $announcement = trim($_POST['announcementInput']);

    // Check if input is empty
    if (empty($announcement)) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Announcement cannot be empty."]);
        exit();
    }

    // Prepare and bind for announcement text
    $stmt = $conn->prepare("INSERT INTO announcements (content, announcement_date, announcement_time) VALUES (?, DATE_FORMAT(NOW(), '%M %d, %Y'), DATE_FORMAT(NOW(), '%h:%i %p'))");
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $announcement);

    // Execute the statement
    if ($stmt->execute()) {
        $announcementId = $stmt->insert_id; // Get the ID of the inserted announcement

        // Now handle the file upload if exists
        if (isset($_FILES['my_image']) && $_FILES['my_image']['error'] === UPLOAD_ERR_OK) {
            $img_name = $_FILES['my_image']['name'];
            $img_size = $_FILES['my_image']['size'];
            $tmp_name = $_FILES['my_image']['tmp_name'];

            if ($img_size > 10000000) { // Limit the file size to 10MB
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Sorry, your file is too large."]);
                exit();
            }

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'uploads/' . $new_img_name;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    // Update the announcement with the image path
                    $update_stmt = $conn->prepare("UPDATE announcements SET image_path = ? WHERE id = ?");
                    if ($update_stmt) { // Check if the statement was prepared successfully
                        $update_stmt->bind_param("si", $new_img_name, $announcementId);

                        if ($update_stmt->execute()) {
                            // Set session status message
                            $_SESSION['status'] = "Announcement created successfully with image.";
                            $_SESSION['status_type'] = "success"; 

                            // Redirect back to announcement.php after successful image upload
                            header('Location: announcement.php');
                            exit(); // Ensure no further code execution after redirection
                        } else {
                            http_response_code(500); // Internal Server Error
                            echo json_encode(["error" => "Failed to update announcement with image path: " . $update_stmt->error]);
                        }
                        $update_stmt->close(); // Close the update statement
                    } else {
                        http_response_code(500); // Internal Server Error
                        echo json_encode(["error" => "Failed to prepare update statement: " . $conn->error]);
                    }
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["error" => "Failed to move uploaded file."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "You can't upload files of this type."]);
            }
        } else {
            // Set session status message if no image is uploaded
            $_SESSION['status'] = "Announcement created successfully without an image.";
            $_SESSION['status_type'] = "success"; 

            // Redirect back to announcement.php if no image is uploaded
            header('Location: announcement.php');
            exit(); // Ensure no further code execution after redirection
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
    
    // Close the statement only if it was opened
    $stmt->close();
}

$conn->close();
?>
