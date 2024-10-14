<?php
include '../config.php';
$page_title = "User Form";
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: ../login.php');
    exit(); // Ensure the script stops execution after redirection
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "barangayportal");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user details from the database
$email = $_SESSION['login_data']['email']; // Assuming the email is stored in the session
$query = "
    SELECT 
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
    FROM tblaccounts 
    WHERE email='$email' 
    LIMIT 1
";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    die("No user data found.");
}

// Search logic
$searchQuery = "";
if (isset($_POST['filter']) && !empty($_POST['searchValue'])) {
    $searchField = mysqli_real_escape_string($con, $_POST['filter']);
    $searchValue = mysqli_real_escape_string($con, $_POST['searchValue']);
    $searchQuery = "AND $searchField LIKE '%$searchValue%'";
}

// Fetch barangay permit data including address, phone, email, code, and other details
$permit_query = "
    SELECT 
        id,
        code, 
        name, 
        address, 
        phone,  
        created_at AS request_date,
        emailad,
        purpose,
        status
    FROM barangay_permits
    WHERE status IN ('Pending', 'Claim') 
    $searchQuery
    ORDER BY request_date DESC
";

$permit_result = mysqli_query($con, $permit_query);

if (!$permit_result) {
    die("Permit data query failed: " . mysqli_error($con));
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
    <title>Barangay Clearance</title>
</head>
<body>
    
<!-- Sidebar ni par -->
<div class="sidebar position-fixed top-0  bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3 ">
    <a href="resident_dashboard.php" class="sidebar-logo text-uppercase text-decoration-none text-navy fs-4 text-dark" style="font-weight: 800;">BES</a>

        <i class="sidebar-toggle ri-git-repository-private-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">


    <li class="sidebar-menu-item  pt-4 pb-3">
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

        <div class="container mt-4">
    <form method="POST" action="">
        <div class="d-flex justify-content-end mb-2">
            <select name="filter" class="form-select me-2" style="width: 200px;">
                <option value="">Select Filter</option>
                <option value="name">Full Name</option>
                <option value="phone">Contact</option>
                <option value="emailad">Email Address</option>
                <option value="purpose">Purpose</option>
                <option value="created_at">Date Created</option>
                <option value="code">Application Code</option>
                <option value="status">Status</option>
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
        <h5 style="padding-bottom: 70px;" class="fw-bold">Results</h5>
        <table class="table text-center">
            <thead>
                <tr>
                    <th class="text-secondary">Full Name</th>
                    <th class="text-secondary">Service Type</th>
                    <th class="text-secondary">Contact</th>
                    <th class="text-secondary">Email Address</th>
                    <th class="text-secondary">Date Request</th>
                    <th class="text-secondary">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display permits fetched from the database
                if ($permit_result && mysqli_num_rows($permit_result) > 0) {
                    while ($row = mysqli_fetch_assoc($permit_result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>Barangay Permit</td>"; // Assuming all permits are Barangay Permits
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['emailad']) . "</td>"; 
                        echo "<td>" . date('m-d-Y H:i A', strtotime($row['request_date'])) . "</td>"; 
                        echo "<td>";
                        if ($row['status'] == 'Pending') {
                            echo "<span class='text-warning fw-bold'>Pending</span>";
                        } else if ($row['status'] == 'Claim') {
                            echo "<span class='text-success fw-bold'>Claim</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No permits found.</td></tr>"; 
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
mysqli_close($con);
?>
        </main>

<!-- Script ni Pare --> 
 <script src="../admin/css/assets/js/bootstrap.bundle.min.js"></script>
 <script src="../admin/css/assets/js/jquery.min.js"></script>
 <script src="../admin/css/assets/js/scriptssaa.js"></script>

 <!-- Data table ni pare -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
  
<!-- Script nato sa scearch pre -->
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