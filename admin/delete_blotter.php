                                            <?php
include '../config.php';
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ids = $_POST['ids'];
    $idsArray = explode(',', $ids);

    // Sanitize IDs
    $idsArray = array_map(function($id) use ($con) {
        return mysqli_real_escape_string($con, $id);
    }, $idsArray);

    // Prepare the query
    $idsList = implode(',', $idsArray);
    $query = "DELETE FROM tblblotter WHERE id IN ($idsList)";

    if (mysqli_query($con, $query)) {
        $_SESSION['status'] = 'Blotter records deleted successfully.';
        $_SESSION['status_type'] = 'success';
    } else {
        $_SESSION['status'] = 'Error: ' . mysqli_error($con);
        $_SESSION['status_type'] = 'danger';
    }

    // Redirect to the main page
    header('Location: blotters.php');
    exit();
}
?>
