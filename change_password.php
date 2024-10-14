<?php
session_start();

$page_title = "Password Change Update";
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
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
        <div style="text-align: center; padding-top:10%;">

     
                                <img src="logo-transparent.png" alt="" style="width: 250px; height: auto;">
                            </div>

                           <br>
                            <br>
                            <?php
                if (isset($_SESSION['status'])) {
                    $success_messages = [
                        'We emailed you a password reset link.',
                        'You have been logged out successfully.',
                        'New password has been successfully updated, please check your Gmail for the new OTP!'
                    ];
                    
                    // Determine the alert class based on the status message
                    $alert_class = in_array($_SESSION['status'], $success_messages) ? 'alert-success' : 'alert-danger';
                    
                    // Display the status message in an alert box
                    echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
                    echo $_SESSION['status'];
                    echo '</div>';
                    
                    // Unset the session status after displaying
                    unset($_SESSION['status']);
                }
                ?>
                                <form action="password-reset-code.php" method="POST">
                                        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">

             
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" id="form3Example3" class="form-control" required />
                                        <label class="form-label" for="form3Example3">Email address</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="number" name="phone" id="form3Example3" class="form-control" required />
                                        <label class="form-label" for="form3Example3">Phone</label>
                                    </div>


                                    <!-- Password input with required attribute -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" name="new_password" id="form3Example4" class="form-control" required />
                                        <label class="form-label" for="form3Example4">New Password</label>
                                    </div>

                                    <!-- Confirm Password input with required attribute -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" name="confirm_password" id="form3Example5" class="form-control" required />
                                        <label class="form-label" for="form3Example5">Confirm Password</label>
                                    </div>
                


                <button type="submit" name="password_update" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-block mb-4" style="background-color: #af2532;">Update Password</button>

            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    
    <script>
        function removeAlert(button) {
            var alertDiv = button.parentElement;
            alertDiv.remove();
        }
    </script>

</body>

</html>
