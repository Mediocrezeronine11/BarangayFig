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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Icon" href="../logosaLafili.png" type="image/png" sizes="16x16">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
     <link rel="stylesheet" href="../admin/css/assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="../admin/css/assets/css/style.css">

    <!-- Bootstrap nga wako kabalo pare -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Announcements</title>
</head>


<body>
    
    
<!-- Sidebar ni par -->
<div class="sidebar position-fixed top-0  bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3 ">
    <a href="admins.php" class="sidebar-logo text-uppercase text-decoration-none text-navy fs-4 text-dark" style="font-weight: 800;">BES</a>

        <i class="sidebar-toggle ri-git-repository-private-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">


    <li class="sidebar-menu-item  pt-4 pb-3">
    <a href="admins.php">
        <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
        Dashboard
    </a>
</li>



    <li class="sidebar-menu-item pb-2 active">
    <a href="announcement.php">
        <i class="ri-megaphone-line sidebar-menu-item-icon"></i>
        Announcements
    </a>
</li>



<li class="sidebar-menu-devider mt-3 mb-1 text-uppercase pb-2">Online processing</li>
        <li class="sidebar-menu-item has-dropdown ">
            <a href="#">
            <i class="ri-mail-open-line sidebar-menu-item-icon"></i>
             Requests 
                <i class="ri-arrow-down-s-fill sidebar-menu-item-accordion ms-auto"></i>
            </a>
            <ul class="sidebar-dropdown-menu m-1">
                
            <li class="sidebar-dropdown-menu-item">
                    <a href="bclearance.php">
                       Barangay Clearance
                    </a>
                </li>

                <li class="sidebar-dropdown-menu-item">
                <a href="bcertificate.php">
                    Residency Certificate
                </a>
            </li>


           
            <li class="sidebar-dropdown-menu-item">
            <a href="bpermit.php">
                       Barangay Permit
                    </a>
                </li>

            </ul>
            

            <li class="sidebar-menu-devider mt-3 mb-1 text-uppercase pb-2">Resident</li>
        <li class="sidebar-menu-item pb-1">
    <a href="residents.php">
        <i class="ri-team-line sidebar-menu-item-icon"></i>
       Total Citizen
    </a>
</li>

    

            </ul>



            
      

    </ul>

</div>


</div>



<div class="sidebar-overlay"> </div>

<!-- Main ni Pare -->
<main class="bg-light">
    <div class="p-2">
    <!-- Navbar ni Pare -->
    <nav class="px-3 py-2 bg-white rounded shadow ">
    <i class="ri-menu-line sidebar-toggle me-3 mt-2 d-block d-md-none"></i>

        <h5 class="fw-bold mb-0 mt-2 me-auto text-dark">Announcements</h5>
        <div class="dropdown me-3 d-none d-sm-block">
         <div class="dropdown-toggle cursor-pointer dropdown-toggle navbar-link " data-bs-toggle="dropdown" aria-expanded="false">
         <i class="ri-notification-line"></i>   
         </div>
         <div class="dropdown-menu fx-dropdown-menu">
            <h5 class="p-3 bg-eweb text-light">Notification</h5>
               
            <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class=" me-auto">
                <div class="fw-semibold">Subheading</div>
                
            <span class="fs-7">Content for list item</span>  
                </div>
                <span class="badge text-bg-primary rounded-pill">14</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class=" me-auto">
                <div class="fw-semibold">Subheading</div>
                
            <span class="fs-7">Content for list item</span>  
                </div>
                <span class="badge text-bg-primary rounded-pill">14</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class=" me-auto">
                <div class="fw-semibold">Subheading</div>
                
            <span class="fs-7">Content for list item</span>  
                </div>
                <span class="badge text-bg-primary rounded-pill">14</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class=" me-auto">
                <div class="fw-semibold">Subheading</div>
                
            <span class="fs-7">Content for list item</span>  
                </div>
                <span class="badge text-bg-primary rounded-pill">14</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class=" me-auto">
                <div class="fw-semibold">Subheading</div>
                
            <span class="fs-7">Content for list item</span>  
                </div>
                <span class="badge text-bg-primary rounded-pill">14</span>
            </a>
            </div>

         </div>
       
        </div>
        
        <div class="dropdown">
         <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2 d-none d-sm-block"><?php echo htmlspecialchars($admin_data['first_name']); ?></span>
            <i class="ri-arrow-drop-down-fill fs-4 "></i>
            <img src="../images/Capture.PNG" alt="" class="navbar-profile-image">
         </div>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
        </ul>
        </div>


        <?php
// Disable error reporting for production
ini_set('display_errors', 0);
error_reporting(0);

// Enable error logging (logs errors to a specific file)
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/E-barangayPartial/php-error.log'); // Adjust this path to your error log location

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
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display status messages if they exist
if (isset($_SESSION['status'])) {
    $alertType = $_SESSION['status_type'] ?? 'danger'; 

    echo '<div class="position-fixed end-0 p-3" style="z-index: 11; top: 10px;">'; // Right side, with spacing from top and right
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
?>








        </nav>
        </div>

        <div class="container mt-4">
    <div class="row">
        <!-- Left Content -->
        <div class="col-md-8">
            <div class="bg-white rounded-3 shadow p-3 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img alt="User profile picture" class="rounded-circle me-2" height="40" src="../Lafili.jpg" width="40"/>
                    <input id="announcementInput" class="form-control rounded-pill" placeholder="Create Announcement" type="text"/>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                    <a class="btn me-2" href="#" data-bs-toggle="modal" data-bs-target="#photoModal">
                        <i class="ri-image-line text-success me-1"></i> Photo
                    </a>
                    <a class="btn me-2" href="#" data-bs-toggle="modal" data-bs-target="#videoModal">
                        <i class="ri-video-chat-fill text-primary me-1"></i> Video
                    </a>
                    </div>
            
          </div>
            </div>

            
                <form action="submit_announcement.php" method="post" enctype="multipart/form-data">
        <!-- Modal for Photo -->
        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel">Upload Photo Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" class="form-control" id="photoInput" name="my_image" accept="image/*" required />
                        <textarea class="form-control mt-2" name="announcementInput" placeholder="Enter your announcement" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary btn-sm shadow-lg fw-semibold mb-2 mb-md-0 rounded-pill" id="postPhotoAnnouncementButton">
                            Post Photo
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>






<!-- Modal for Video -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Upload Video Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control" id="videoInput" accept="video/*" />
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-primary btn-sm shadow-lg fw-semibold mb-2 mb-md-0 rounded-pill" id="postVideoAnnouncementButton">
                    Post Video
                    <i class="ri-add-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>




            
<!-- Existing Announcement Card with Delete Button -->
<div id="announcementContainer">
    <div class="bg-white rounded-3 shadow p-3 mb-4 position-relative" id="announcement-<?= $announcementId ?>">
        <div class="d-flex position-absolute top-0 end-0 me-3 mt-3">
            <button class="btn btn-link text-dark" aria-label="Pin" 
                data-bs-toggle="modal" data-bs-target="#pinConfirmationModal" 
                data-announcement-id="<?= $announcementId ?>">
                <i class="ri-pushpin-2-line"></i>
            </button>
        </div>

        <div class="card-header d-flex align-items-center">
            <img alt="Profile picture of Mufti Hidayat" class="rounded-circle me-2" height="40" src="../Lafili.jpg" width="40"/>
            <div>
                <div class="fw-bold">Mufti Hidayat</div>
                <div class="text-muted">Project Manager</div>
            </div>
            <div class="ms-auto text-muted">
                <i class="fas fa-ellipsis-h"></i>
            </div>
        </div>
    </div>
</div>




            <!-- Pin Confirmation Modal -->
            <div class="modal fade" id="pinConfirmationModal" tabindex="-1" aria-labelledby="pinConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pinConfirmationLabel">Confirm Pinning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to pin this announcement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmPinButton">Pin
                <i class="ri-pushpin-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>




        </div>

        <!-- Right Content -->
<div class="col-md-4">
    <div class="card shadow-sm border-0 ">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">Pinned Announcement</span>
        </div>
        <div class="card-body overflow-auto" style="max-height: 400px;"> <!-- Use Bootstrap classes here -->
            <div class="post mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img alt="Profile picture of Panji Dwi" class="rounded-circle me-2" height="40" src="https://storage.googleapis.com/a1aa/image/wQ2KAJfmEfiwgEITzbVkcmoonCBcQnGn8RsWbkRKfNqYwQHnA.jpg" width="40"/>
                    <div class="me-auto">
                        <span class="fw-bold">Panji Dwi</span>
                        <span class="badge bg-light text-dark ms-2">Pinned</span>
                    </div>
                </div>
                <div class="d-flex align-items-center text-muted mb-2">
                    <i class="ri-chat-3-line me-1"></i> General
                </div>  
                <div class="post-content text-muted mb-2">
                    Welcome to Tiimi People 🥳 <br/>
                    We're thrilled to share some exciting updates with you! Our...
                </div>
                <a class="text-primary text-decoration-none" href="#">View post &gt;</a>
            </div>
            <hr/>
            <div class="post mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img alt="Profile picture of Raihan Fikri" class="rounded-circle me-2" height="40" src="https://storage.googleapis.com/a1aa/image/e8OrrTpH4R3FQinluraVvozKncqiejSmGrKc208I0wCNYojTA.jpg" width="40"/>
                    <div class="me-auto">
                        <span class="fw-bold">Raihan Fikri</span>
                        <span class="badge bg-light text-dark ms-2">Pinned</span>
                    </div>
                </div>
                <div class="d-flex align-items-center text-muted mb-2">
                    <i class="ri-file-text-line me-1"></i> SOP Updates
                </div>
                <div class="post-content text-muted mb-2">
                    We've been hard at work behind the scenes refining our...
                </div>
                <a class="text-primary text-decoration-none" href="#">View post &gt;</a>
            </div>
            <hr/>
            <div class="post mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img alt="Profile picture of Raihan Fikri" class="rounded-circle me-2" height="40" src="https://storage.googleapis.com/a1aa/image/e8OrrTpH4R3FQinluraVvozKncqiejSmGrKc208I0wCNYojTA.jpg" width="40"/>
                    <div class="me-auto">
                        <span class="fw-bold">Raihan Fikri</span>
                        <span class="badge bg-light text-dark ms-2">Pinned</span>
                    </div>
                </div>
                <div class="d-flex align-items-center text-muted mb-2">
                    <i class="ri-chat-3-line me-1"></i> General
                </div>
                <div class="post-content text-muted mb-2">
                    I've got some exciting news to share with you all! We've recently...
                </div>
                <a class="text-primary text-decoration-none" href="#">View post &gt;</a>
            </div>
        </div>
    </div>
</div>

  
 <!-- Modal Sa Post Pare -->
 <div class="modal fade" id="primaryAddressModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Create Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                    <label for="announcementDropdown" class="form-label">Select Announcement</label>
                    <select id="announcementDropdown" class="form-select">
                    <option value="mute" disabled selected>Select an option</option>
                        <option value="1">Community Events</option>
                        <option value="2">Meeting</option>
                        <option value="3">Health and Safety Reminders</option>
                        <option value="4">Other Announcements</option>
                    </select>
                </div>
                <form id="announcementForm" method="POST" enctype="multipart/form-data" action="submit_announcement.php">
                <textarea id="announcementTextarea" class="form-control mt-2" name="announcementInput" placeholder="Enter your announcement" style="width: 100%; height: 500px;" required></textarea>

                    <div class="mb-3"></div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="d-flex">
                    <a class="btn me-2" href="#" data-bs-toggle="modal" data-bs-target="#photoModal">
                        <i class="ri-image-line text-success me-1"></i> Photo
                    </a>
                    <a class="btn me-2" href="#" data-bs-toggle="modal" data-bs-target="#videoModal">
                        <i class="ri-video-chat-fill text-primary me-1"></i> Video
                    </a>
                </div>

                <button type="submit" class="btn btn-primary btn-sm shadow-lg fw-semibold mb-2 mb-md-0 rounded-pill" id="postAnnouncementButton" form="announcementForm">
                    Post
                    <i class="ri-add-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>






<!-- Modal for Video -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Upload Video Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control" id="videoInput" accept="video/*" />
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-primary btn-sm shadow-lg fw-semibold mb-2 mb-md-0 rounded-pill" id="postVideoAnnouncementButton">
                    Post Video
                    <i class="ri-add-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>



        </main>

<!-- Script ni Pare --> 
 <script src="../admin/css/assets/js/bootstrap.bundle.min.js"></script>
 <script src="../admin/css/assets/js/jquery.min.js"></script>
 <script src="../admin/css/assets/js/scriptssaa.js"></script>
 <script src="../admin/css/assets/js/announcementsar.js"></script>

 <!-- Data table ni pare -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 


 

</body>
</html>