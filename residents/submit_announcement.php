<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if (isset($_SESSION['status'])) {
    $alertType = $_SESSION['status_type'] ?? 'danger'; 

  

    echo '<div class="position-fixed end-0 p-3 " style="z-index: 11; top: 10px; ">'; 
    echo '<div class="toast show align-items-center text-white bg-' . $alertType . ' border-0" role="alert" aria-live="assertive" aria-atomic="true">';
    echo '<div class="d-flex">';
    echo '<div class="toast-body">';
    echo $_SESSION['status'];
    echo '</div>';
    echo '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

 
    unset($_SESSION['status']);
    unset($_SESSION['status_type']);
}

include '../config.php'; 


header('Content-Type: application/json');


$conn = $con; 


if (!$conn) {
    http_response_code(500); 
    echo json_encode(["error" => "Connection failed: " . mysqli_connect_error()]);
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pinned'])) {
    $query = "SELECT * FROM announcements WHERE is_pinned = 1 ORDER BY id DESC"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $pinnedAnnouncements = [];
        while ($row = $result->fetch_assoc()) {
            $pinnedAnnouncements[] = $row; 
        }
        echo json_encode($pinnedAnnouncements);
    } else {
        echo json_encode([]); 
    }
    $conn->close();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT * FROM announcements ORDER BY id DESC"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $announcements = [];
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row; 
        }
        echo json_encode($announcements);
    } else {
        echo json_encode([]); 
    }
    $conn->close();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['delete']) && isset($_GET['id'])) {
    $announcementId = intval($_GET['id']);
    
   
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    if (!$stmt) {
        http_response_code(500); 
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }
    
    $stmt->bind_param("i", $announcementId);

    
    if ($stmt->execute()) {

        $_SESSION['status'] = "Announcement deleted successfully.";
        $_SESSION['status_type'] = "success"; 

        http_response_code(200); 
        echo json_encode(["success" => "Announcement deleted successfully."]);
    } else {
        http_response_code(500); 
        echo json_encode(["error" => "Failed to delete announcement: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_GET['delete'])) {
    
    $announcement = trim($_POST['announcementInput']);

    
    if (empty($announcement)) {
        http_response_code(400); 
        echo json_encode(["error" => "Announcement cannot be empty."]);
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO announcements (content, announcement_date, announcement_time) VALUES (?, DATE_FORMAT(NOW(), '%M %d, %Y'), DATE_FORMAT(NOW(), '%h:%i %p'))");
    if (!$stmt) {
        http_response_code(500); 
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $announcement);

    
    if ($stmt->execute()) {
        $announcementId = $stmt->insert_id; 

      
        if (isset($_FILES['my_image']) && $_FILES['my_image']['error'] === UPLOAD_ERR_OK) {
            $img_name = $_FILES['my_image']['name'];
            $img_size = $_FILES['my_image']['size'];
            $tmp_name = $_FILES['my_image']['tmp_name'];

            if ($img_size > 10000000) { 
                http_response_code(400); 
                echo json_encode(["error" => "Sorry, your file is too large."]);
                exit();
            }

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../admin/uploads/' . $new_img_name;

               
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                   
                    $update_stmt = $conn->prepare("UPDATE announcements SET image_path = ? WHERE id = ?");
                    if ($update_stmt) { 
                        $update_stmt->bind_param("si", $new_img_name, $announcementId);

                        if ($update_stmt->execute()) {
                           
                            $_SESSION['status'] = "Announcement created successfully with image.";
                            $_SESSION['status_type'] = "success"; 

                          
                            header('Location: announcement.php');
                            exit(); 
                        } else {
                            http_response_code(500); 
                            echo json_encode(["error" => "Failed to update announcement with image path: " . $update_stmt->error]);
                        }
                        $update_stmt->close(); 
                    } else {
                        http_response_code(500); 
                        echo json_encode(["error" => "Failed to prepare update statement: " . $conn->error]);
                    }
                } else {
                    http_response_code(500); 
                    echo json_encode(["error" => "Failed to move uploaded file."]);
                }
            } else {
                http_response_code(400); 
                echo json_encode(["error" => "You can't upload files of this type."]);
            }
        } else {
          
            $_SESSION['status'] = "Announcement created successfully without an image.";
            $_SESSION['status_type'] = "success"; 

          
            header('Location: announcement.php');
            exit(); 
        }
    } else {
        http_response_code(500); 
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
    

    $stmt->close();
}

$conn->close();
?>
    