<?php
include '../config.php';
$page_title = "Admin Form";
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit(); // Ensure the script stops execution after redirection
}

// Fetch admin details from the database
$email = $_SESSION['login_data']['email']; // Assuming the email is stored in the session
$query = "SELECT 
    first_name, 
    last_name, 
    middle_name, 
    age,
    gender,    
    birthdate,    
    place_of_birth,    
    user_type,    
    phone,
    civil_status,    
    verify_token,    
    position,
    barangay_name,
    city_municipality,
    province,
    zip_code
    FROM tblaccounts 
    WHERE email='$email' 
    LIMIT 1";  // Updated query

$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

$admin_data = mysqli_fetch_assoc($result);

if (!$admin_data) {
    die("No admin data found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .announcement-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            width: 300px;
        }
        .alb {
            width: 100%;
            height: auto;
            padding: 5px;
            text-align: center;
        }
        .alb img {
            width: 100%;
            border-radius: 8px;
        }
        a {
            text-decoration: none;
            color: black;
            margin: 20px;
            font-size: 18px;
        }
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .card-header img {
            border-radius: 50%;
            margin-right: 10px;
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <a href="index.php">&#8592; Back</a>
    <div id="announcementContainer">
        <?php 
        // Use $con instead of $conn
        $sql = "SELECT * FROM announcements ORDER BY created_at DESC"; 
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            while ($announcement = mysqli_fetch_assoc($res)) { 
                $announcementId = $announcement['id'];
                $content = htmlspecialchars($announcement['content']);
                $imagePath = $announcement['image_path'];
                $pinned = $announcement['is_pinned'] ? '<span class="text-success">Pinned</span>' : ''; 
                ?>
                <div class="announcement-card" id="announcement-<?= $announcementId ?>">
                    <div class="card-header">
                        <img alt="Profile picture" class="rounded-circle" height="40" src="https://storage.googleapis.com/a1aa/image/B8nKIVpcae2MWyOflQUa84G0ZGkdsrGtGE27nD1dvRkITojTA.jpg" width="40"/>
                        <div>
                            <div class="fw-bold">Admin <?= $pinned ?></div>
                            <div class="text-muted">Posted on <?= htmlspecialchars($announcement['announcement_date']) ?></div>
                        </div>
                    </div>
                    <p><?= $content ?></p>
                    <?php if (!empty($imagePath)): ?>
                        <div class="alb">
                            <img src="uploads/<?= $imagePath ?>" alt="Announcement Image">
                        </div>
                    <?php endif; ?>
                </div>
        <?php 
            }
        } else {
            echo "<p>No announcements available.</p>";
        } 
        ?>
    </div>
</body>
</html>

<?php
// Close the database connection at the end of the script
mysqli_close($con);
?>
