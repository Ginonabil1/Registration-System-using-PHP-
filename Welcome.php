<?php

session_start();

include 'header.php';

$user = array();

if (isset($_SESSION['userID'])) {
    include 'Database.php';
    $user = get_user_info($conn, $_SESSION['userID']);
}else{
    header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<body>
<section id="main-site">
    <div class="container py-5">
        <div class="row">
            <div class="col-4 offset-4 shadow py-4">
                <div class="upload_img d-flex justify-content-center pb-5">
                    <div class="text-center">
                        <img class="img rounded-circle" style="width: 200px; height: 200px;" src="<?php echo isset($user['profileImage']) ? $user['profileImage'] : './imgs/profile/beard.png'; ?>" alt="Profile Image">
                        <h4 class="py-3">
                            <?php
                            if (isset($user['FirstName'])) {
                                printf('%s %s', $user['FirstName'], $user['LastName']);
                            }
                            ?>
                        </h4>
                    </div>
                </div>

                <div class="user-info px-3">
                    <ul class="font-ubuntu navbar-nav">
                        <li class="nav-link"><b>First Name: </b><span><?php echo isset($user['FirstName']) ? $user['FirstName'] : ''; ?></span></li>
                        <li class="nav-link"><b>Last Name: </b><span><?php echo isset($user['LastName']) ? $user['LastName'] : ''; ?></span></li>
                        <li class="nav-link"><b>Email: </b><span><?php echo isset($user['email']) ? $user['email']: ''; ?></span></li>
                    </ul>
                    <div class="text-center">
                        <button class="btn btn-warning rounded-pill  px-5 my-3"><a href="logout.php" class="text-dark text-decoration-none">Logout</a> </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
</body>
</html>


<?php

function get_user_info($conn, $userID) {
    $stmt = mysqli_prepare($conn, "SELECT FirstName, LastName, email, profileImage FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row;
}
?>
