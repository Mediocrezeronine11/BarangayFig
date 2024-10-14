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


$query = "SELECT * FROM tblaccounts";
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
    <title>Admin</title>
</head>
<body>
    
<!-- Sidebar ni par -->
<div class="sidebar position-fixed top-0  bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3 ">
    <a href="admins.php" class="sidebar-logo text-uppercase text-decoration-none text-navy fs-4 text-dark" style="font-weight: 800;">BES</a>
        <i class="sidebar-toggle ri-git-repository-private-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">


    <li class="sidebar-menu-item pt-4 pb-3">
    <a href="admins.php">
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
            

            <li class="sidebar-menu-devider mt-3 mb-1 text-uppercase pb-2">Resident</li>
        <li class="sidebar-menu-item active pb-1">
    <a href="residents.php">
        <i class="ri-team-line sidebar-menu-item-icon"></i>
       Total Citizen
    </a>
</li>

        
        

            
      

    </ul>

</div>



<div class="sidebar-overlay"> </div>

<!-- Main ni Pare -->
<main class="bg-light">
    <div class="p-2">
    <!-- Navbar ni Pare -->
    <nav class="px-3 py-2 bg-white rounded shadow ">
    <i class="ri-menu-line sidebar-toggle me-3 mt-2 d-block d-md-none"></i>

        <h5 class="fw-bold mb-0 mt-2 me-auto text-dark">Total Residents</h5>
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

        

        </nav>
        </div>
        

    </div>
   <!-- Records per page Dropdown and Buttons -->
<section class="table-section p-4">
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label for="recordsPerPage" class="form-label text-muted">Records Per Page:</label>
                <select id="recordsPerPage" class="form-select form-select-sm" onchange="updateRecordsPerPage()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-end">
                <button type="button" class="btn btn-success text-light btn-sm shadow-lg fw-semibold mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#primaryAddressModal">
                    Add Blotter
                    <i class="ri-add-line"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm shadow-lg fw-semibold ms-0 ms-sm-2" id="deleteSelectedBtn">
                    Delete Selected
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive table-bordered">
            <table class="table align-middle table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" id="selectAll" class="form-check-input" data-bs-toggle="tooltip" data-bs-placement="top" title="Check all">
                            Select All
                        </th>
                        <th class="text-center">No.</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Age</th>
                        <th class="text-center">Former Address</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="blotterTableBody">
                    <?php
                    // Initialize counter
                    $counter = 1;

                    // Loop through the results and display them
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td class="text-center">
                                <input type="checkbox" name="select_record[]" value="' . $row['id'] . '" class="form-check-input">
                              </td>';
                        echo '<td class="text-center fw-bold ">' . $counter . '.</td>';
                        echo '<td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="ms-3 text-center">
                                        <p class="mb-1">' . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . '</p>
                                    </div>
                                </div>
                              </td>';
                        echo '<td class="text-center">' . htmlspecialchars($row['age']) . '</td>';
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

            <div class="d-flex justify-content-between align-items-center mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link text-dark" href="#">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link text-light" style="background-color: #008080;" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

                <nav aria-label="breadcrumb" class="d-flex justify-content-end mt-3" style="color: #008080;">
                    <ol class="breadcrumb" style="background-color: transparent;">
                        <li class="breadcrumb-item"><a href="admins.php" style="color: #008080;">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blotter</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

        </main>

<!-- Script ni Pare --> 
 <script src="../admin/css/assets/js/bootstrap.bundle.min.js"></script>
 <script src="../admin/css/assets/js/jquery.min.js"></script>
 <script src="../admin/css/assets/js/scriptssaa.js"></script>

 <!-- Data table ni pare -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 

</body>
</html>