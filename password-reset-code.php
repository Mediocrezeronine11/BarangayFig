<?php
session_start(); // Ensure the session is started

include('config.php'); // Ensure config file is included for database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token, $new_password = null) 
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'ebrgyweb0911@gmail.com'; // SMTP username
        $mail->Password   = 'pmgm zxcm lmwy tahj'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('ebrgyweb0911@gmail.com', 'E-Brgy Web');
        $mail->addAddress($get_email, $get_name); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $new_password ? 'Password Updated Successfully' : 'Password Reset Request';

        if ($new_password) {
            $email_template = "
            <div style='font-family: Arial, sans-serif; border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto;'>
                <div style='background-color: #f7f7f7; padding: 10px 20px; border-bottom: 1px solid #ddd;'>
                    <h3 style='color: #333; font-size: 24px;'>Password Updated Successfully</h3>
                </div>
                <div style='padding: 20px;'>
                    <p style='font-size: 16px; color: #555;'>Hi $get_name,</p>
                    <p style='font-size: 16px; color: #555;'>Your password has been successfully updated. Here are your new credentials:</p>
                    <p style='font-size: 16px; color: #555;'>New Password: $new_password</p>
                    <p style='font-size: 16px; color: #555;'>Your new OTP for future use is: $token</p>
                    <p style='font-size: 16px; color: #555;'>Please keep this information safe and secure.</p>
                    <p style='font-size: 16px; color: #999;'>Thank you!</p>
                </div>
            </div>
            ";
        } else {
            $email_template = "
            <div style='font-family: Arial, sans-serif; border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto;'>
                <div style='background-color: #f7f7f7; padding: 10px 20px; border-bottom: 1px solid #ddd;'>
                    <h3 style='color: #333; font-size: 24px;'>Password Reset Request</h3>
                </div>
                <div style='padding: 20px;'>
                    <p style='font-size: 16px; color: #555;'>Hi $get_name,</p>
                    <p style='font-size: 16px; color: #555;'>We received a request to reset your password. Please click the link below to reset your password:</p>
                    <a href='http://localhost/E-barangayPartial/change_password.php?token=$token' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #af2532; text-decoration: none; border-radius: 4px;'>Reset Password</a>
                    <p style='font-size: 16px; color: #555; margin-top: 20px;'>If you did not request a password reset, please ignore this email.</p>
                    <p style='font-size: 16px; color: #999;'>Thank you!</p>
                </div>
            </div>
            ";
        }

        $mail->Body    = $email_template;
        $mail->AltBody = $new_password ? 
            "Your password has been updated. Your new password is: $new_password\nYour new OTP for future use is: $token\n\nPlease keep this information safe." : 
            "We received a request to reset your password. Please click the link below to reset your password:\n\nhttp://localhost/E-barangayPartial/change_password.php?token=$token\n\nIf you did not request a password reset, please ignore this email.\n\nThank you!";

        $mail->send();
        $_SESSION['status'] = $new_password ? "We emailed you your new password and OTP." : "We emailed you a password reset link.";
    } catch (Exception $e) {
        $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log("Mailer Error: " . $mail->ErrorInfo); // Log the error for debugging
    }
}

if (isset($_POST['password-reset-link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = rand(100000, 999999); // Generate a 6-digit OTP

    $check_email = "SELECT first_name, email FROM tbladmin WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['first_name'];
        $get_email = $row['email'];

        $update_token = "UPDATE tbladmin SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            header("Location: login.php"); // Redirect to login page after sending reset link
            exit();
        } else {
            $_SESSION['status'] = "Something went wrong. Please try again.";
            header("Location: login.php"); // Redirect to login page
            exit();
        }
    } else {
        $_SESSION['status'] = "No Email Found";
        header("Location: login.php"); // Redirect to login page
        exit();
    }
}

if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($phone) && !empty($new_password) && !empty($confirm_password)) {
            // Checking if token is valid or not
            $check_token = "SELECT password, verify_token, phone FROM tbladmin WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                $user_row = mysqli_fetch_array($check_token_run);

                if ($user_row['phone'] == $phone) {
                    // Check if the new password matches the old password
                    if (password_verify($new_password, $user_row['password'])) {
                        $_SESSION['status'] = "This is your old password. Please choose a different one.";
                        header("Location: change_password.php?token=$token&email=$email");
                        exit();
                    }

                    if ($new_password == $confirm_password) {
                        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $update_password = "UPDATE tbladmin SET password='$new_password_hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($con, $update_password);

                        if ($update_password_run) {
                            $new_token = rand(100000, 999999); // Generate a new 6-digit OTP
                            $update_to_new_token = "UPDATE tbladmin SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($con, $update_to_new_token);

                            if ($update_to_new_token_run) {
                                send_password_reset($email, $email, $new_token, $new_password); // Send new OTP and password
                                $_SESSION['status'] = "New Password Updated Successfully.";
                                header("Location: login.php"); // Redirect to login page after success
                                exit();
                            } else {
                                $_SESSION['status'] = "Failed to update token.";
                                header("Location: change_password.php?token=$token&email=$email");
                                exit();
                            }
                        } else {
                            $_SESSION['status'] = "Failed to update password.";
                            header("Location: change_password.php?token=$token&email=$email");
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "Passwords do not match.";
                        header("Location: change_password.php?token=$token&email=$email");
                        exit();
                    }
                } else {
                    $_SESSION['status'] = "Phone number does not match.";
                    header("Location: change_password.php?token=$token&email=$email");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Invalid Token.";
                header("Location: login.php"); // Redirect to login page if token is invalid
                exit();
            }
        } else {
            $_SESSION['status'] = "All fields are required.";
            header("Location: change_password.php?token=$token&email=$email");
            exit();
        }
    } else {
        $_SESSION['status'] = "No Token Found";
        header("Location: login.php"); // Redirect to login page if no token found
        exit();
    }
}
?>
