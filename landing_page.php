<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "barangayportal");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch email addresses from tblaccounts
$query = "SELECT email FROM tblaccounts";
$result = mysqli_query($con, $query);

$email_addresses = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $email_addresses[] = $row['email'];
    }
}

// Close the connection
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay E-System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="Icon" href="logosaLafili.png" type="image/png" sizes="16x16">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        h3 {
            margin-bottom: 1.5rem;
        }

        .bg-body-white {
            background-color: white !important;
        }

        .navbar {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .login-btn,
        .signin-link {
            position: relative;
            margin-left: 10px;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                align-items: center;
                padding: 1rem 0;
                width: 100%;
            }

            .custom-input {
                width: 100%;
                margin-bottom: 1rem;
            }

            img {
                display: none;
            }

            .login-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                margin: 0;
            }

            .signin-link {
                position: absolute;
                top: 1rem;
                right: 8rem;
                margin: 0;
            }

            .input-center {
                justify-content: center;
                text-align: center;
                width: 100%;
            }

            .input-group input {
                max-width: 90%;
                height: 40px;
            }

            .input-group .btn {
                height: 40px;
                padding: 0.5rem;
            }

            .nav-center {
                justify-content: center;
                text-align: center;
                width: 100%;
            }

            .nav-center .navbar-nav {
                flex-direction: column;
                padding: 1rem 0;
            }

            .get-started-btn {
                display: none;
            }

            .content-center {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .content-center img {
                margin-top: 2rem;
            }
        }

        @media (min-width: 769px) {
            .custom-input {
                width: 200px;
            }

            .content-center {
                display: flex;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-light bg-body-light shadow-none ">
    <div class="container py-5">
        <a class="navbar-brand" style="font-weight: 1000;" href="#">
            Barangay E-System
        </a>
        <div class="d-flex justify-content-center flex-grow-1 nav-center">
            <ul class="navbar-nav d-flex flex-row gap-3 fw-semibold gap-5">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Help</a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ms-auto d-flex flex-row gap-4 fw-semibold">
            <li class="nav-item">
                <a class="nav-link signin-link shadow-md" href="register.php" style="color:#008080;">Sign In</a>
            </li>
            <li class="nav-item">
                <a href="login.php" class="btn btn-info text-white fw-bold login-btn" style="background-color:#008080; padding: 0.5rem 1rem;">
                    Login
                </a>
            </li>
        </ul>
    </div>
</nav>







<section class="container">
    
    <div class="row mb-5 pt-5 content-center">
        <div class="col-12 col-md-6">
            <h3 class="my-5 display-6 fw-bold fs-10 text-dark">
                Barangay Database Integration <br />
                for <span style="color:#008080;">Local Government </span>
                <span style="color:#008080;">Administration </span>
                <br>
                <span style="color:#008080;">Login Form </span>
            </h3>

            <p class="mt-4" style="color: hsl(217, 10%, 50.8%);">
                Opportunities Cost effective, user-friendly 
                <br>
                and affordable system that is also 
                <br>
                internet-ready.
            </p>

            <div class="input-group mt-3 py-4 input-center">
                <input type="text" class="form-control me-2 shadow-lg custom-input" placeholder="Track your Request!" style="max-width: 50%; height: 50px; outline: none;">
                <button type="button" class="btn btn-lg text-light fw-bold get-started-btn" style="background-color:#008080;">
                    Get Started 
                </button>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
            <img src="logosaLafili.png" alt="Logo" class="img-fluid" style="max-width: 70%; height: auto;">
        </div>
    </div>
</section>

<img src="mask.png" class="pt-5" alt="" style="padding-left:15%;">




<?php if (isset($_SESSION['status'])): ?>
    <?php 
        $alertType = $_SESSION['status_type'] ?? 'danger'; 
    ?>
    <div class="position-fixed end-0 p-3" style="z-index: 11; top: 10px;">
        <div id="statusToast" class="toast show align-items-center text-white bg-<?php echo $alertType; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php 
                        echo $_SESSION['status']; 
                        unset($_SESSION['status']); 
                        unset($_SESSION['status_type']); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        
        setTimeout(function() {
            var toast = document.getElementById('statusToast');
            if (toast) {
                toast.classList.remove('show'); 
                toast.classList.add('fade'); 
               
                setTimeout(function() {
                    toast.remove();
                }, 300); 
            }
        }, 3000); 
    </script>
<?php endif; ?>




<section>

    <div class="container mt-5 pt-5 text-center fw-bold">
        <h1 class="fw-bold">
            ONLINE DOCUMENTS <span class=" fs-10" style="color: #008080;">OFFERED</span>
        </h1>

        <br>
        <br>
        <br>
        <br>
        

        <div class="row justify-content-center mt-5 pt-5">
        
        <div class="col-12 col-md-4 mb-4">
    <div class="card shadow-lg" style="width: 100%;">
        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 683px;">
            <h4 class="card-title fw-bold" style="color: #008080;">BARANGAY CLEARANCE</h4>
            <br>
            <br>
            <span>View the requirements needed for Barangay Clearance 
            <span>and acquire online now</span></span>
            <br>
            <br>
            <br>
            <a href="#" class=" fw-bold p-2 mb-2  text-white" style="background-color: #008080;" data-mdb-toggle="modal" data-mdb-target="#barangayClearanceModal">Proceed</a>
            <br>
        </div>
    </div>
</div>



<!-- Barangay Clearance ni pare na modal -->
<div class="modal fade" id="barangayClearanceModal" tabindex="-1" aria-labelledby="barangayClearanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangayClearanceModalLabel">Barangay Clearance Form</h5>
                <a href="landing_page.php" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form action="submit_barangay_clearance.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
                        </div>

                        <div class="col-md-6">
                            <input type="tel" class="form-control" name="contact" placeholder="Contact number" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select class="form-control" name="emailad" required>
                                <option value="" disabled selected>Select your email</option>
                                <?php foreach ($email_addresses as $email): ?>
                                    <option value="<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="purpose" placeholder="State the purpose" required>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="submission_date" id="submission_date" required>
                        </div>
                        <div class="col-md-6">
                <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
            </div>

                    </div>

                        <br>
                                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn text-light fw-bold" style="background-color: #008080;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





        <div class="col-12 col-md-4 mb-4">
    <div class="card shadow-lg" style="width: 100%;">
        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 683px;">
            <h4 class="card-title fw-bold" style="color: #008080;">RESIDENCY CERTIFICATE</h4>
            <br>
            <br>
            <span>View the requirements needed for Residency Certificate
                <span>and acquire online now</span>
            </span>
            <br>
            <br>
            <br>
            <a href="#" class="fw-bold  p-2 mb-2 text-white" style="background-color: #008080;" data-mdb-ripple-init data-mdb-toggle="modal" data-mdb-target="#residencyModal">Proceed</a>
            <br>
        </div>
    </div>
</div>

<!-- Residency Modal ni Pre  -->

<div class="modal fade" id="residencyModal" tabindex="-1" aria-labelledby="residencyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="residencyModalLabel">Residency Certificate Application</h5>
                <a href="landing_page.php" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form action="submit_residency_certificates.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="fullName" placeholder="Enter your full name" required>
                        </div>
                    <div class="col-md-6">
                    <input type="tel" class="form-control" name="contact_number" placeholder="Enter your contact number" required>

                        </div>
                    </div>
                    <div class="row mb-3">
        
                        <div class="col-md-6">
                            <select class="form-control" name="emailad" required>
                                <option value="" disabled selected>Select your email</option>
                                <?php foreach ($email_addresses as $email): ?>
                                    <option value="<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="purpose" placeholder="State the purpose" required>
                        </div>
                    </div>
                    <div class="row mb-3 pt-3">
                        <div class="col-md-6">
                        <input type="text" class="form-control" name="address" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn text-light fw-bold" style="background-color: #008080;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






<div class="col-12 col-md-4 mb-4">
    <div class="card shadow-lg" style="width: 100%;">
        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 683px;">
            <h4 class="card-title fw-bold" style="color: #008080;">BUSINESS PERMIT</h4>
            <br>
            <br>
            <span>View the requirements needed for Barangay Permit and acquire online now</span>
            <br>
            <br>
            <br>
            <a href="#" class="fw-bold p-2 mb-2 text-white" style="background-color: #008080;" data-mdb-toggle="modal" data-mdb-target="#businessPermitModal">Proceed</a>
            <br>
        </div>
    </div>
</div>

<!-- Business Permit Modal ni pare -->
<div class="modal fade" id="businessPermitModal" tabindex="-1" aria-labelledby="businessPermitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="businessPermitModalLabel">Business Permit</h5>
                <a href="landing_page.php" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form action="submit_business_permit.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
                        </div>

                    <div class="col-md-6">
                            <input type="tel" class="form-control" name="phone" placeholder="Enter your phone number" required>
                        </div>
           

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select class="form-control" name="emailad" required>
                                <option value="" disabled selected>Select your email</option>
                                <?php foreach ($email_addresses as $email): ?>
                                    <option value="<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="purpose" placeholder="State the purpose" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn text-light fw-bold" style="background-color: #008080;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    </div>
    
    </div>


</section>

<br>
<br>
<br>
<br>
<br>

<footer class="text-center text-lg-start text-white pt-5" style="background-color: #008080;">

  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">

    <div class="me-5 d-none d-lg-block">
     
    </div>



    <div>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>

  </section>

  
 

  
  <section class="">
    <div class="container text-center text-md-start mt-5">

      <div class="row mt-3">
    
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
      
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Barangay E-System
          </h6>
          <p>
          Our expert financial consultants provide solutions to help you achieve financial wealth. Trust us to guide you toward a brighter financial future.
          </p>
        </div>



        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

          <h6 class="text-uppercase fw-bold mb-4">
          Our Services
          </h6>
          <p>
            <a href="#!" class="text-reset">Angular</a>
          </p>
          <p>
            <a href="#!" class="text-reset">React</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Vue</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Laravel</a>
          </p>
        </div>



        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
 
          <h6 class="text-uppercase fw-bold mb-4">
          Explore More
          </h6>
          <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Orders</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Help</a>
          </p>
        </div>


 
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
   
          <h6 class="text-uppercase fw-bold mb-4">Contact Details</h6>
          <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            info@example.com
          </p>
          <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
        </div>

      </div>

    </div>
  </section>



  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2021 Copyright:
    <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>

</footer>




</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Y5q5n5M5b4hcpxyD9F7jL+Y5q5n5M5b4hcpxyD9F7jL+Y5q5n5M5b4hcpxyD9F7j"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>


</body>

</html>
