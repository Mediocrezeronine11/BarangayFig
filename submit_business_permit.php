<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$con = mysqli_connect("localhost", "root", "", "barangayportal");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to generate a unique code
function generateUniqueCode($length = 5) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $code;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['emailad']);  
    $purpose = mysqli_real_escape_string($con, $_POST['purpose']);
    $submission_date = isset($_POST['submission_date']) ? mysqli_real_escape_string($con, $_POST['submission_date']) : date('Y-m-d H:i:s');

    $status = 'Pending';

    // Generate unique code
    $uniqueCode = generateUniqueCode(5); 

    // Insert into barangay_permits
    $sql = "INSERT INTO barangay_permits (code, name, address, phone, emailad, purpose, submission_date, status) 
            VALUES ('$uniqueCode', '$name', '$address', '$phone', '$email', '$purpose', '$submission_date', '$status')";

    if (mysqli_query($con, $sql)) {
        $_SESSION['status'] = "New permit created successfully with Pending status!";
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