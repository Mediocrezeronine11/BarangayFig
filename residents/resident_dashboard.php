<?php
include '../config.php';
$page_title = "User Form";
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: ../login.php');
    exit(); // Ensure the script stops execution after redirection
}

// Fetch user details from the database
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
    verify_token,    
    position,
    barangay_name,
    city_municipality,
    civil_status,
    province,
    zip_code  
    FROM tblaccounts WHERE email='$email' LIMIT 1";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

$user_data = mysqli_fetch_assoc($result);

$query = "SELECT * FROM tblaccounts";
$result = mysqli_query($con, $query);


if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

$admin_data = mysqli_fetch_assoc($result);

if (!$admin_data) {
    die("No admin data found.");
}

// Initialize total request counter
$totalRequests = 0;


// Fetch ni siya sa total account sa table sa tblaccounts except sa admin nako 
$totalResidentsResult = mysqli_query($con, "SELECT COUNT(*) as count FROM tblaccounts WHERE user_type != 'admin'");
$totalResidentsRow = mysqli_fetch_assoc($totalResidentsResult);
$totalResidents = $totalResidentsRow['count'];

// Initialize total request counter
$totalRequests = 0;


// pampma count sa barangay clearance ni pre
$resultClearance = mysqli_query($con, "SELECT COUNT(*) as count FROM barangay_clearance");
$rowClearance = mysqli_fetch_assoc($resultClearance);
$totalRequests += $rowClearance['count'];

// count request sa barangay permit
$resultPermits = mysqli_query($con, "SELECT COUNT(*) as count FROM barangay_permits");
$rowPermits = mysqli_fetch_assoc($resultPermits);
$totalRequests += $rowPermits['count'];

// Count requests sa baangay application or katong residency 
$resultApplications = mysqli_query($con, "SELECT COUNT(*) as count FROM barangay_applications");
$rowApplications = mysqli_fetch_assoc($resultApplications);
$totalRequests += $rowApplications['count'];

// total request ni migo
$_SESSION['total_requests'] = $totalRequests;


if (!$user_data) {
    die("No user data found.");
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
    <title>Resident</title>
</head>
<body>
    
<!-- Sidebar ni par -->
<div class="sidebar position-fixed top-0  bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3 ">
    <a href="resident_dashboard.php" class="sidebar-logo text-uppercase text-decoration-none text-navy fs-4 text-dark" style="font-weight: 800;">BES</a>
        <i class="sidebar-toggle ri-git-repository-private-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">


    <li class="sidebar-menu-item  active pt-4 pb-3">
    <a href="resident_dashboard.php">
        <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
        Dashboard
    </a>
</li>



    <li class="sidebar-menu-item pb-2">
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
            <ul class="sidebar-dropdown-menu">
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
            

    

            </ul>

            
      

    </ul>

</div>

<div class="sidebar-overlay"> </div>

<!-- Main ni Pare -->
<main class="bg-light">
    <div class="p-2">
    <!-- Navbar ni Pare -->
    <nav class="px-3 py-2 bg-white rounded shadow ">
    <i class="ri-menu-line sidebar-toggle me-3 mt-2 d-block d-md-none"></i>


    <h5 class="fw-bold mb-0 mt-2 me-auto text-dark">Dashboard</h5>
<div class="dropdown me-3 d-none d-sm-block">
    <div class="dropdown-toggle cursor-pointer dropdown-toggle navbar-link position-relative" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-notification-line"></i>
        <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
            0
        </span>
    </div>

    <div class="dropdown-menu fx-dropdown-menu">
        <h5 class="p-3 bg-eweb text-light">Notification
            <i class="ri-megaphone-fill"></i>
        </h5>
        
        <div class="list-group list-group-flush" id="announcementDropdownList">
            
        <a href="announcement.php" class="btn btn-link text-dark fw-bold rounded-pill text-end">See All</a>
        
        </div>
    </div>

<div id="announcementContainer" class="d-none">
    <!-- Announcements will be injected here -->
</div>



        </div>
        
        <div class="dropdown">
         <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2 d-none d-sm-block"><?php echo htmlspecialchars($user_data['first_name']); ?></span>
            <i class="ri-arrow-drop-down-fill fs-4 "></i>
            <img src="../images/Capture.PNG" alt="" class="navbar-profile-image">
         </div>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
        </ul>
        </div>

        </nav>
        </div>

        <div class="container mt-5">
    <div class="card p-4 shadow-sm rounded">
        <div class="row text-center">
            <div class="col-12 col-md">
                <div class="h6 text-muted">Total Residents</div>
                <div class="display-4 text-dark"><?php echo $totalResidents; ?></div>
            </div>
            <div class="col-auto d-none d-md-block">
                <div class="vr" style="height: 60px;"></div>
            </div>
            <div class="col-12 col-md">
    <div class="col-12 col-md">
    <div class="h6 text-muted">Total Requests</div>
    <div class="display-4 text-dark"><?php echo $totalRequests; ?></div>
</div>

</div>

            <div class="col-auto d-none d-md-block">
                <div class="vr" style="height: 60px;"></div>
            </div>
            <div class="col-12 col-md">
            <div class="h6 text-muted">Total Account Register</div>
            <div class="display-4 text-dark"><?php echo $totalResidents; ?></div>
            </div>
        </div>
    </div>



    <div class="container mt-4">
    <div class="d-flex justify-content-end mb-2">
        <input type="text" class="form-control me-2" placeholder="Search.." style="width: 200px;">
        <button type="button" class="btn btn-md text-light" style="background-color:#008080;">
            <i class="ri-search-line"></i>
        </button>
    </div>

    <div class="bg-white rounded shadow-sm p-4">
        <h5 style="padding-bottom: 70px;" class="fw-bold">Total Citezen</h5>
        <table class="table text-center">
            <thead>
                <tr>
                    <th class="text-secondary">Full Name</th>
                    <th class="text-secondary">Age</th>
                    <th class="text-secondary">Birthdate</th>
                    <th class="text-secondary">Place of Birth</th>
                    <th class="text-secondary">City/Municipality</th>
                    <th class="text-secondary">Gender</th>
                    <th class="text-secondary">Date Request</th>
                    <th class="text-secondary">Actions</th>
                </tr>
            </thead>
            <tbody id="blotterTableBody">
                    <?php
                    // Initialize counter
                    $counter = 1;

                    // Loop through the results and display them
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td class="text-center fw-bold ">' . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . '.</td>';
                        echo '<td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="ms-3 text-center">
                                        <p class="mb-1">' . htmlspecialchars($row['age']) . '</p>
                                    </div>
                                </div>
                              </td>';
                        echo '<td class="text-center">' . htmlspecialchars($row['birthdate']) . '</td>';
                       echo '<td class="text-center">' . htmlspecialchars($row['place_of_birth']) . '</td>';
                       echo '<td class="text-center">' . htmlspecialchars($row['city_municipality']) . '</td>';
                        echo '<td class="text-center">' . htmlspecialchars($row['gender']) . '</td>';
                        echo '<td class="text-center">Test</td>'; // Replace 'Test' with the actual column if available
                        echo '<td>
                                <div class="d-flex justify-content-center w-100">
                                    <button type="button" class="btn btn-link btn-m btn-rounded text-dark me-2 shadow-sm fw-semibold border border-dark" data-bs-toggle="modal" data-bs-target="#viewBlotterModal" data-id="' . $row['id'] . '">Details</button>
                                </div>
                              </td>';
                        echo '</tr>';
                        $counter++;
                    }
                    ?>
                </tbody>
        </table>
    </div>
</div>

</div>

        </div>






        </main>

<!-- Script ni Pare --> 
 <script src="../admin/css/assets/js/bootstrap.bundle.min.js"></script>
 <script src="../admin/css/assets/js/jquery.min.js"></script>
 <script src="../admin/css/assets/js/scriptssaa.js"></script>
 <script src="../residents/assets/js/announcementsares.js"></script>

 <!-- Data table ni pare -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 

</body>
</html>