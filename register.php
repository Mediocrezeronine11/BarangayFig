<?php
session_start();
include 'config.php';
$page_title = "Registration Form";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Check if an admin already exists
$check_admin = "SELECT * FROM tblaccounts WHERE user_type = 'admin'";
$result_check_admin = mysqli_query($con, $check_admin);
$admin_exists = mysqli_num_rows($result_check_admin) > 0;

function sendemail_verify($fullname, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ebrgyweb0911@gmail.com';
        $mail->Password   = 'pmgm zxcm lmwy tahj'; // Consider using environment variables for security
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Set the sender email
        $mail->setFrom('ebrgyweb0911@gmail.com', 'E-Brgy Web');
        
        // Send the OTP to ebrgyweb0911@gmail.com
        $mail->addAddress('ebrgyweb0911@gmail.com'); // Change to user email in production

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification From E-Brgy Web!';

        // Correct the variable and ensure double quotes for variable parsing
        $email_template = "
       <div style='font-family: Arial, sans-serif; border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto;'>
    <div style='background-color: #f7f7f7; padding: 10px 20px; border-bottom: 1px solid #ddd;'>
        <h3 style='color: #333; font-size: 24px;'>You've Registered with E-Brgy Web</h3>
    </div>
    <div style='padding: 20px;'>
        <p style='font-size: 16px; color: #555;'>This Code belongs to <strong>$fullname</strong>,</p>
        
        <p style='font-size: 16px; color: #555;'>$fullname Barangay verification code is:</p>
        
        <h1 style='font-size: 48px; color: #333; margin: 20px 0;'>$otp</h1>
        
        <p style='font-size: 16px; color: #555;'>Please use this code to verify your registration.</p>
    </div>
</div>

        ";

        $mail->Body = $email_template;
        $mail->send();

        echo 'OTP has been sent to ebrgyweb0911@gmail.com';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = mysqli_real_escape_string($con, $_POST['user_type']); // Sanitize user_type input
    $position = isset($_POST['position']) ? mysqli_real_escape_string($con, $_POST['position']) : null;
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $civil_status = mysqli_real_escape_string($con, $_POST['civil_status']);
    $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
    $place_of_birth = mysqli_real_escape_string($con, $_POST['place_of_birth']);
    $barangay_name = mysqli_real_escape_string($con, $_POST['barangay_name']);
    $city_municipality = mysqli_real_escape_string($con, $_POST['city_municipality']);
    $province = mysqli_real_escape_string($con, $_POST['province']);
    $zip_code = mysqli_real_escape_string($con, $_POST['zip_code']);
    $otp = rand(100000, 999999); // Generate a random 6-digit OTP

    // Check for existing admin if user_type is 'admin'
    if ($user_type === 'admin') {
        $check_admin = "SELECT * FROM tblaccounts WHERE user_type = 'admin'";
        $result_check_admin = mysqli_query($con, $check_admin);
        if (mysqli_num_rows($result_check_admin) > 0) {
            $_SESSION['status'] = 'An admin already exists. Only one admin is allowed!';
            header('location: register.php');
            exit();
        }
    }

    // Check for existing email in tblaccounts
    $select_admin = "SELECT * FROM tblaccounts WHERE email = '$email'";
    $result_admin = mysqli_query($con, $select_admin);

    if (mysqli_num_rows($result_admin) > 0) {
        $_SESSION['status'] = 'User already exists!';
        header('location: register.php');
        exit();
    }

    if ($password != $cpassword) {
        $_SESSION['status'] = 'Passwords do not match!';
        header('location: register.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into tblaccounts
    $insert_admin = "INSERT INTO tblaccounts (first_name, middle_name, last_name, age, email, phone, password, user_type, position, gender, civil_status, birthdate, place_of_birth, barangay_name, city_municipality, province, zip_code, verify_token, otp_verified) 
                    VALUES ('$first_name', '$middle_name', '$last_name', '$age', '$email', '$phone', '$hashed_password', '$user_type', '$position', '$gender', '$civil_status', '$birthdate', '$place_of_birth', '$barangay_name', '$city_municipality', '$province', '$zip_code', '$otp', 0)";

    $query_run_admin = mysqli_query($con, $insert_admin);

    if (!$query_run_admin) {
        echo 'Error inserting into tblaccounts: ' . mysqli_error($con);
        exit();
    }

    sendemail_verify($first_name . ' ' . $middle_name . ' ' . $last_name, $otp);

    $_SESSION['status'] = 'Registration successful! Please check your email to verify your account.';
    header('location: login.php');
    exit();
}
?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="Icon" href="logosaLafili.png" type="image/png" sizes="16x16">
    
    <!-- MDB UI Kit CSS for UI components and grid system -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    
    <!-- Font Awesome for social media icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Optional custom stylesheet -->
    <link rel="stylesheet" href="style.css">
    
    <!-- GSAP for animations (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/ScrollTrigger.min.js"></script>
    
    <title>Register</title>
    <style>
        .position-container {
            display: none;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <!-- Section: Design Block -->
 <!-- Section: Design Block -->
<section class="w-100">
    <!-- Jumbotron with background covering full width -->
    <div class="px-4 py-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%);">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                
                <!-- Left Column: Responsive Heading and Text -->
                <div class="col-md-12 col-lg-6 mb-5">
        <h3 class="my-5 display-6 fw-bold fs-10 text-dark">
         Barangay Database Integration  <br />
         for <span  style="color:#008080;">Local Government </span>
    <span style="color:#008080;">Administration </span>
    <br>
    <span style="color:#008080;">Registration Form </span>
</h3>

          <img src="logo1.png" alt="Logo" class="img-fluid" style="max-width: 100%; height: auto;">
          <p class="mt-4" style="color: hsl(217, 10%, 50.8%);">
          Opportunities Cost effective, user-friendly 
          <br>
          and affordable system that is also 
          <br>
          internet-ready.
          </p>
        </div>

                <!-- Right Column: Responsive Registration Form -->
                <div class="col-lg-6 mb-5 mb-lg-0" style="padding-top: 500px;">
                    <div class="card">
                        <div class="text-center" style="padding-top: 70px;">
                            <img src="logosaLafili.png" alt="" class="img-fluid" style="max-width: 200px; height: auto;">
                        </div>

                        <h2 class="text-center text-dark" style=" padding-top: 5%;">Barangay San Miguel</h2>
                        <div class="card-body py-5 px-md-5">
                            <form action="" method="post">
                                <?php
                                if (isset($error)) {
                                    foreach ($error as $error) {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                        echo $error;
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="removeAlert(this)"></button>';
                                        echo '</div>';
                                    }
                                }
                                if (isset($_SESSION['status'])) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo $_SESSION['status'];
                                    echo '</div>';
                                    unset($_SESSION['status']);
                                }
                                ?>

                                <!-- Responsive grid layout for name inputs -->
                                <select class="form-select mb-4" name="user_type" id="user_type_select" aria-label="Default select example" onchange="showPositionDropdown()">
                                    <option value="" disabled selected>Select User Type</option>
                                    <option value="Admin" <?php echo $admin_exists ? 'disabled' : ''; ?>>Admin</option>
                                    <option value="Residents">Residents</option>
                                </select>


                                <!-- Name and other inputs -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="first_name" id="form3Example1" class="form-control" required />
                                            <label class="form-label" for="form3Example1">First name</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="last_name" id="form3Example2" class="form-control" required />
                                            <label class="form-label" for="form3Example2">Last name</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="middle_name" id="form3Example3" class="form-control" />
                                            <label class="form-label" for="form3Example3">Middle name</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="number" name="age" id="form3Example4" class="form-control" required />
                                            <label class="form-label" for="form3Example4">Age</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="date" name="birthdate" id="form3Example5" class="form-control" required />
                                            <label class="form-label" for="form3Example5">Birthdate</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="place_of_birth" id="form3Example6" class="form-control" required />
                                            <label class="form-label" for="form3Example6">Place of birth</label>
                                        </div>
                                    </div>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="barangay_name" id="form3Example7" class="form-control" required />
                                    <label class="form-label" for="form3Example7">Barangay Name</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="city_municipality" id="form3Example8" class="form-control" required />
                                            <label class="form-label" for="form3Example8">City/Municipality</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" name="province" id="form3Example9" class="form-control" required />
                                            <label class="form-label" for="form3Example9">Province</label>
                                        </div>
                                    </div>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="zip_code" id="form3Example10" class="form-control" required />
                                    <label class="form-label" for="form3Example10">Zip Code</label>
                                </div>

                                <select class="form-select mb-4" name="gender" id="gender_select" aria-label="Select Gender">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>

                                <select class="form-select mb-4" name="civil_status" id="civil_status" aria-label="Civil Status">
                                    <option value="" disabled selected>Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" name="email" id="form3Example11" class="form-control" required />
                                    <label class="form-label" for="form3Example11">Email address</label>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="number" name="phone" id="form3Example12" class="form-control" required />
                                    <label class="form-label" for="form3Example12">Phone</label>
                                </div>

                                <!-- Password input with required attribute -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" name="password" id="form3Example13" class="form-control" required />
                                    <label class="form-label" for="form3Example13">Password</label>
                                </div>

                                <!-- Confirm Password input with required attribute -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" name="cpassword" id="form3Example14" class="form-control" required />
                                    <label class="form-label" for="form3Example14">Confirm Password</label>
                                </div>

                                <!-- Submit button with large size and primary color -->
                                <button type="submit" name="submit" class="btn btn-info btn-block mb-4 " style="background-color: #008080;">
                                    Register
                                </button>

                                <div class="form-check mb-4" style="position: relative; text-align: right; padding-top: 2%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <a href=""  style=" margin-right: 10px; color:#008080;">.......</a>
                                        <label class="form-check-label" for="form2Example33">
                                            Already have an account? 
                                            <a href="login.php" style="color: #008080;">Sign in</a>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

    <!-- MDB UI Kit JS for interactive elements -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>


    <!-- Mao ni atong script sa dropdown sa Official Pare -->
    <script src="scripts/script.js"></script>


   


</body>
</html>