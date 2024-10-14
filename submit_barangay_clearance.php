<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$con = mysqli_connect("localhost", "root", "", "barangayportal");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateUniqueCode($length = 5) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $code;
}

// Handle form submission for barangay clearance
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $address = mysqli_real_escape_string($con, $_POST['address']); // Ensure this is included
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['emailad']);  
    $purpose = mysqli_real_escape_string($con, $_POST['purpose']);
    $submission_date = mysqli_real_escape_string($con, $_POST['submission_date']); 

    $status = 'Pending';

    // Generate unique code
    $uniqueCode = generateUniqueCode(5); 

    $sql = "INSERT INTO barangay_clearance (code, name, address, contact, emailad, purpose, submission_date, status) 
            VALUES ('$uniqueCode', '$name', '$address', '$contact', '$email', '$purpose', '$submission_date', '$status')";

    if (mysqli_query($con, $sql)) {
        $_SESSION['status'] = "New record created successfully with Pending status!";
        $_SESSION['status_type'] = "success"; 
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($con);
        $_SESSION['status_type'] = "danger"; 
    }

    header("Location: landing_page.php"); 
    exit();
}

mysqli_close($con);
?>
