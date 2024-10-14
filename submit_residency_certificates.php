<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$con = mysqli_connect("localhost", "root", "", "barangayportal");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateUniqueCode($length = 5) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $code;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching and escaping input data
    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contactNumber = mysqli_real_escape_string($con, $_POST['contact_number']); // Updated here
    $emailad = mysqli_real_escape_string($con, $_POST['emailad']); 
    $purpose = mysqli_real_escape_string($con, $_POST['purpose']);

    // Set default status
    $status = 'Pending';

    // Generate unique application code
    $applicationCode = generateUniqueCode(5); 

    // Adjusting the SQL query to match the correct column names
    $sql = "INSERT INTO barangay_applications (application_code, full_name, address, contact_number, emailad, purpose, status) 
            VALUES ('$applicationCode', '$fullName', '$address', '$contactNumber', '$emailad', '$purpose', '$status')";

    if (mysqli_query($con, $sql)) {
        $_SESSION['status'] = "New application submitted successfully! Your code: $applicationCode";
        $_SESSION['status_type'] = "success"; 
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($con);
        $_SESSION['status_type'] = "danger"; 
    }

    // Redirect to the landing page
    header("Location: landing_page.php"); 
    exit();
}

// Close connection
mysqli_close($con);
?>