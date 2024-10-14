<?php
session_start();
include 'config.php';
$page_title = "OTP Verification";

// Check if the user is already verified
if (isset($_SESSION['login_data']['email'])) {
    $email = $_SESSION['login_data']['email'];
    $check_verified_query = "SELECT otp_verified, user_type, first_name FROM tblaccounts WHERE email='$email' LIMIT 1";
    $check_verified_result = mysqli_query($con, $check_verified_query);

    if (!$check_verified_result) {
        die("Database query failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($check_verified_result) > 0) {
        $user = mysqli_fetch_assoc($check_verified_result);

        // If the user is already verified, redirect them based on their user type
        if ($user['otp_verified'] == 1) {
            switch ($user['user_type']) {
                case 'Admin':
                    $_SESSION['admin_name'] = $user['first_name'];
                    $_SESSION['status'] = "Already logged in as Admin";
                    header('Location:  admin/admins.php');
                    exit;

                case 'Residents':
                    $_SESSION['user_name'] = $user['first_name'];
                    $_SESSION['status'] = "Already logged in as Resident";
                    header('Location: residents/resident_dashboard.php');
                    exit;

                default:
                    $_SESSION['status'] = "Invalid user type";
                    header("Location: login.php");
                    exit;
            }
        }
    }
}

// Handle OTP verification
if (isset($_POST['verify_otp_btn'])) {
    if (!empty(trim($_POST['otp']))) {
        $otp = mysqli_real_escape_string($con, $_POST['otp']);

        // Check if the OTP matches and if otp_verified is 0
        $otp_query = "SELECT * FROM tblaccounts WHERE email='$email' AND verify_token='$otp' AND otp_verified = 0 LIMIT 1";
        $otp_query_run = mysqli_query($con, $otp_query);

        if (!$otp_query_run) {
            die("Database query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($otp_query_run) > 0) {
            $row = mysqli_fetch_assoc($otp_query_run);

            // Update otp_verified to 1
            $update_otp_status = "UPDATE tblaccounts SET otp_verified = 1 WHERE email='$email'";
            mysqli_query($con, $update_otp_status);

            // Set session variables and redirect based on user type
            switch ($row['user_type']) {
                case 'Admin':
                    $_SESSION['admin_name'] = $row['first_name'];
                    $_SESSION['status'] = "Login as Admin";
                    header('Location: admin/admins.php');
                    exit;

                case 'Residents':
                    $_SESSION['user_name'] = $row['first_name'];
                    $_SESSION['status'] = "Login as Resident";
                    header('Location: residents/resident_dashboard.php');
                    exit;

                default:
                    $_SESSION['status'] = "Invalid user type";
                    header("Location: login.php");
                    exit;
            }
        } else {
            // If OTP is incorrect, reset otp_verified to 0
            $reset_otp_status = "UPDATE tblaccounts SET otp_verified = 0 WHERE email='$email'";
            mysqli_query($con, $reset_otp_status);

            $_SESSION['status'] = "Invalid OTP";
            header("Location: otp_verification.php");
            exit;
        }
    } else {
        $_SESSION['status'] = "OTP is required";
        header("Location: otp_verification.php");
        exit;
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="Icon" href="sanmigprof.jpg" type="image/png" sizes="16x16">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: hsl(0, 0%, 96%);">
    <section class="w-100">
        <div class="px-4 py-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%); width: 100%;">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-5 display-3 fw-bold ls-tight">
                            OTP Verification <br />
                            <span style="color: #008080;">Enter OTP (one time  password)</span>
                        </h1>
                        <p style="color: hsl(217, 10%, 50.8%);">
                       Your One Time Password has been send to your gmail account.Please enter the number below.
                       Don't share this code with anyone.
                        </p>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">
                        
                            <div style="text-align: center; padding-top:10%;">
                                <img src="sanmigprof.jpg" alt="" style="width: 250px; height: auto;">
                            </div>
                            <h2 class="text-center" style="color: #008080; padding-top:5%"> OTP Verification</h2>
                            <div class="card-body py-5 px-md-5">
                            <?php
                                    if (isset($_SESSION['status'])) {
                                        $alert_class = 'alert-danger'; // Default alert class
                                        echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
                                        echo $_SESSION['status'];
                                        echo '</div>';
                                        unset($_SESSION['status']);
                                    }
                                    ?>
                                <form action="" method="post">
                              
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="otp" id="otp" class="form-control" required />
                                        <label class="form-label" for="otp">Enter OTP</label>
                                    </div>
                                    <button type="submit" name="verify_otp_btn" class="btn btn-info btn-block mb-4" style="background-color: #008080; color:#fff;">
                                        Verify OTP
                                    </button>
                                    <div class="form-check mb-4" style="position: absolute; text-align: right;">
                                        <a href="login.php" style="color: #008080; margin-right: 65px;">Back to Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
    <script>
    function removeAlert(button) {
        var alertDiv = button.parentElement;
        alertDiv.remove();
    }
</script>

</body>
</html>
