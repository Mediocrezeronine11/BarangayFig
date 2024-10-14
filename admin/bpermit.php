<?php
include '../config.php';
$page_title = "Admin Form";
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit(); 
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "barangayportal");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetching admin email from session
$email = $_SESSION['login_data']['email']; 

// Admin query
$admin_query = "SELECT 
    first_name, 
    last_name, 
    middle_name, 
    age,
    gender,    
    birthdate,    
    place_of_birth,    
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
    LIMIT 1";  

$admin_result = mysqli_query($con, $admin_query);

// Check if query succeeded
if (!$admin_result) {
    die("Admin data query failed: " . mysqli_error($con));
}

// Fetch admin data
$admin_data = mysqli_fetch_assoc($admin_result);

if (!$admin_data) {
    die("No admin data found.");
}

// Search logic for barangay permits
$searchQuery = "";
if (isset($_POST['filter']) && !empty($_POST['searchValue'])) {
    $searchField = mysqli_real_escape_string($con, $_POST['filter']);
    $searchValue = mysqli_real_escape_string($con, $_POST['searchValue']);
    
    // Adjust this mapping according to your actual database columns
    $validFields = [
        'code' => 'code',
        'name' => 'name',
        'address' => 'address',
        'phone' => 'phone',       // original column name, not alias
        'email' => 'emailad',     // original column name, not alias
        'purpose' => 'purpose',
        'created_at' => 'created_at'
    ];

    if (array_key_exists($searchField, $validFields)) {
        $searchQuery = "{$validFields[$searchField]} LIKE '%$searchValue%'";
    }
}

// Barangay permit query
$permit_query = "
    SELECT 
        id,            
        code,         
        name, 
        address, 
        phone AS contact, 
        emailad AS email,  
        purpose, 
        created_at AS request_date,
        status
    FROM barangay_permits
    WHERE status IN ('Pending', 'Claim')
";

// Add search query if it exists
if (!empty($searchQuery)) {
    $permit_query .= " AND $searchQuery"; // Use AND to append search conditions
}

$permit_query .= " ORDER BY request_date DESC"; // Add ORDER BY clause

$permit_result = mysqli_query($con, $permit_query);

// Check if query succeeded
if (!$permit_result) {
    die("Permit data query failed: " . mysqli_error($con));
}

// Handle status update if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clearance_id'])) {
    $clearance_id = mysqli_real_escape_string($con, $_POST['clearance_id']);
    $new_status = mysqli_real_escape_string($con, $_POST['status']);

    // Update query for status change
    $sql = "UPDATE barangay_permits SET status='$new_status' WHERE id='$clearance_id'";

    // Check if update was successful
    if (mysqli_query($con, $sql)) {
        $_SESSION['status'] = "Status updated successfully!";
        $_SESSION['status_type'] = "success";
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($con);
        $_SESSION['status_type'] = "danger";
    }

    // Redirect after updating status
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Close the database connection
mysqli_close($con);
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
    <title>Barangay Clearance</title>
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


            <li class="sidebar-dropdown-menu-item" style="background-color: #008080; border: 2px solid #ffffff; border-radius: 8px;">
            <a href="bpermit.php"  style="color: white; text-decoration: none; display: block; padding: 5px;">
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



<div class="sidebar-overlay"> </div>

<!-- Main ni Pare -->
<main class="bg-light">
    <div class="p-2">
    <!-- Navbar ni Pare -->
    <nav class="px-3 py-2 bg-white rounded shadow  ">
    <i class="ri-menu-line sidebar-toggle me-3 mt-2 d-block d-md-none"></i>

        <h5 class="fw-bold mb-0 mt-2 me-auto text-dark">Barangay Permit</h5>
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

        <div class="container mt-4">
    <form method="POST" action="">
        <div class="d-flex justify-content-end mb-2">
            <select name="filter" class="form-select me-2" style="width: 200px;">
                <option value="">Select Filter</option>
                <option value="code">Code</option>
                <option value="name">Full Name</option>
                <option value="address">Address</option>
                <option value="contact">Contact Number</option>
                <option value="email">Email</option>
                <option value="purpose">Purpose</option>
                <option value="created_at">Date Request</option>
            </select>
            <input type="text" name="searchValue" class="form-control me-2" placeholder="Search.." style="width: 200px;">
            <button type="submit" class="btn btn-md text-light" style="background-color:#008080;">
                <i class="ri-search-line"></i>
            </button>
            <button type="submit" name="reset" class="btn btn-md text-light ms-2" style="background-color:#008080;">
            <i class="ri-restart-line"></i> Reload
            </button>
        </div>
    </form>

    <div class="bg-white rounded shadow-sm p-4">
        <h5 style="padding-bottom: 70px;" class="fw-bold">Pending Permits</h5>
        <table class="table text-center">
            <thead>
                <tr>
                    <th class="text-secondary">Code</th>
                    <th class="text-secondary">Full Name</th>
                    <th class="text-secondary">Address</th>
                    <th class="text-secondary">Email Address</th>
                    <th class="text-secondary">Contact</th>
                    <th class="text-secondary">Purpose</th>
                    <th class="text-secondary">Date Request</th>
                    <th class="text-secondary">Status</th>
                    <th class="text-secondary">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Clear search if reload button is pressed
                if (isset($_POST['reload'])) {
                    // Reset search query
                    $searchQuery = "";
                    $_POST['filter'] = "";  // Clear selected filter
                    $_POST['searchValue'] = "";  // Clear search value
                }

                // Your existing permit query logic remains unchanged...
                if ($permit_result && mysqli_num_rows($permit_result) > 0) {
                    while ($row = mysqli_fetch_assoc($permit_result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['contact']) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['purpose']) . "</td>"; 
                        echo "<td>" . date('m-d-Y H:i A', strtotime($row['request_date'])) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='clearance_id' value='" . htmlspecialchars($row['id']) . "' />
                                    <select class='form-select' name='status' onchange='this.form.submit()' style='width: 160px;'>
                                        <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . " class='text-warning'>Pending</option>
                                        <option value='Claim' " . ($row['status'] == 'Claim' ? 'selected' : '') . " class='text-success'>Claim</option>
                                    </select>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No permits found.</td></tr>"; 
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



        </main>

<!-- Script ni Pare --> 
 <script src="../admin/css/assets/js/bootstrap.bundle.min.js"></script>
 <script src="../admin/css/assets/js/jquery.min.js"></script>
 <script src="../admin/css/assets/js/scriptssaa.js"></script>

 <!-- Data table ni pare -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 

  <!-- Script sa search ni mga Pare! -->
  <script>
         $(document).ready(function() {
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) { // Enter key pressed
                $(this).closest('form').submit();
            }
        });
    });
    </script>
    
</body>
</html>