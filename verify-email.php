<?php
session_start();
$page_title = "Verify_Email Form";
include('config.php');

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']); // Sanitize the token

    // Check if the token exists and get the verification status from all relevant tables
    $verify_query = "
        SELECT 'tbladmin' AS table_name, verify_status FROM tbladmin WHERE verify_token='$token' LIMIT 1
        UNION
        SELECT 'tblofficial' AS table_name, verify_status FROM tblofficial WHERE verify_token='$token' LIMIT 1
        UNION
        SELECT 'tblresident' AS table_name, verify_status FROM tblresident WHERE verify_token='$token' LIMIT 1
    ";
    $verify_query_run = mysqli_query($con, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_assoc($verify_query_run);
        $table_name = $row['table_name'];
        $verify_status = $row['verify_status'];

        if ($verify_status == "0") {
            // Update verification status to '1'
            $update_query = "UPDATE $table_name SET verify_status='1' WHERE verify_token='$token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);

            if ($update_query_run) {
                $_SESSION['status'] = "Your account has been verified successfully!";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Verification failed. Please try again.";
                header("Location: login.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Email already verified. Please log in.";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "This token does not exist.";
        header("Location: login.php");
        exit(0);
    }
} else {
    $_SESSION['status'] = "Access not allowed.";
    header("Location: login.php");
    exit(0);
}
?>
