<?php
session_start();
include 'config.php';
$page_title = "Login Form";

// maga Handle Login ni migo
if (isset($_POST['login_now_btn'])) {
    // Validate input fields ni siyag input fields
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['user_type']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $user_type = mysqli_real_escape_string($con, $_POST['user_type']);
        $position = isset($_POST['position']) ? mysqli_real_escape_string($con, $_POST['position']) : '';

        // mao ning naga check if ang account kay nag exist naba
        $login_query = "SELECT * FROM tblaccounts WHERE email='$email' LIMIT 1";
        $login_query_run = mysqli_query($con, $login_query);

        if (!$login_query_run) {
            die("Database query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_assoc($login_query_run);

            // ga verify og hash password
            if (password_verify($password, $row['password'])) {
                // ga check og usertype
                if ($row['user_type'] === $user_type && ($user_type !== 'Officials' || $row['position'] === $position)) {
                    // Ga Store user data in session
                    $_SESSION['login_data'] = [
                        'email' => $row['email'],
                        'user_id' => $row['id']
                    ];

                    // Ma Redirect sa OTP verification page
                    header('Location: otp_verification.php');
                    exit(0);
                } else {
                    $_SESSION['status'] = "User type or position does not match";
                }
            } else {
                $_SESSION['status'] = "Invalid Email or Password";
            }
        } else {
            $_SESSION['status'] = "User not found";
        }
    } else {
        $_SESSION['status'] = "All fields are mandatory";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Icon" href="logosaLafili.png" type="image/png" sizes="16x16">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <style>
        .position-container {
            display: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<section class="w-100">
  <div class="px-4 py-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%);">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
       
        <div class="col-md-12 col-lg-6 mb-5">
        <h3 class="my-5 display-6 fw-bold fs-10 text-dark">
         Barangay Database Integration  <br />
         for <span  style="color:#008080;">Local Government </span>
    <span style="color:#008080;">Administration </span>
    <br>
    <span style="color:#008080;">Login Form </span>
</h3>

          <img src="logo.png" alt="Logo" class="img-fluid" style="max-width: 100%; height: auto;">
          <p class="mt-4" style="color: hsl(217, 10%, 50.8%);">
          Opportunities Cost effective, user-friendly 
          <br>
          and affordable system that is also 
          <br>
          internet-ready.
          </p>
          
        </div>
        
        <div class="col-md-12 col-lg-6">
          <div class="card">
            <div class="text-center pt-4">
            <a href="landing_page.php">
              <img src="logosaLafili.png" alt="San Miguel" class="img-fluid" style="max-width: 250px; height: auto; cursor: pointer;">
            </a>
            </div>
            <h2 class="text-center text-dark" style=" Padding-top:5%;">Barangay San Miguel</h2>
            <div class="card-body py-5 px-md-5">
              <form action="" method="post">
               
                <?php
                if (isset($_SESSION['status'])) {
                  $success_messages = [
                    'We emailed you a password reset link.',
                    'You have been logged out successfully.',
                    'New password has been successfully updated, please check your Gmail for the new OTP!',
                    'Login as Admin',
                    'Login as Resident',
                    'Registration successful! Please verify your email.',
                    'Registration successful! Please check your email to verify your account.',
                    'Login as Official'
                  ];

                  $error_messages = [
                    'Invalid OTP or OTP has already changed.',
                    'Invalid Email or Password',
                    'User not found',
                    'All fields are mandatory',
                    'User type does not match',
                    'Invalid user type'
                  ];

                  $alert_class = in_array($_SESSION['status'], $success_messages) ? 'alert-success' : 'alert-danger';
                  echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
                  echo $_SESSION['status'];
                  echo '</div>';
                  unset($_SESSION['status']);
                }
                ?>

             
                <div class="mb-4">
                  <select class="form-select" name="user_type" id="user_type">
                    <option value="Admin">Admin</option>
                    <option value="Residents">Residents</option>
                  </select>
                </div>

                

               
                <div class="form-outline mb-4">
                  <input type="email" name="email" id="form3Example3" class="form-control" required />
                  <label class="form-label" for="form3Example3">Email address</label>
                </div>

           
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form3Example4" class="form-control" required />
                  <label class="form-label" for="form3Example4">Password</label>
                </div>

         
                <button type="submit" name="login_now_btn" class="btn btn-info btn-block mb-4" style="background-color: #008080;">
                  Login
                </button>

             
                <div class="d-flex justify-content-between align-items-center">
                  <a data-mdb-toggle="modal" data-mdb-target="#forgotPasswordModal" class="text-dark" style=" cursor: pointer;">Forgot Your Password?</a>
                  <label class="form-check-label">
                    Already have an account? 
                    <a href="register.php"  style="color:#008080;">Sign up</a>
                  </label>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" id="forgotPasswordModalLabel">Forgot Your Password?</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>

      
                <form action="password-reset-code.php" method="POST">
                    <div class="card-body py-4 px-md-4">
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="email" name="email" id="form3Example3" class="form-control" required />
                            <label class="form-label" for="form3Example3">Email address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text-light" name="password-reset-link" style="background-color: #008080;">Reset Password</button>
                    </div>
                </form>
           
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
</body>
</html>
