
<?php
session_start();

include 'header.php';

if(isset($_SESSION["userID"])){       
    header("Location: Welcome.php");
}

    include 'Database.php';

  if(isset($_POST["submit"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' ";
    $result = mysqli_query($conn , $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION["fname"] = $row["FirstName"];
        $_SESSION["lname"] = $row["LarstName"];
        $_SESSION['userID'] = $row["id"];
        header("Location:Welcome.php");
    }else{
        echo "<script>alert('Wrong email or password..!')</script>";
    }
  }


  mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<body>
<section id="login-form">
    <div class="row m-0">
        <div class="col-lg-4 offset-lg-2">
            <div class="text-center pb-3">
                <h1 class="login-title text-dark">Login</h1>
                <p class="p-1 m-0 text-black-50">Login and enjoy additional features</p>
                <span class="text-black-50">Create a new <a href="register.php">account</a></span>
            </div>
            <div class="upload_img d-flex justify-content-center pb-3">
                <div class="text-center">
                    <img src="<?php echo isset($user['profileImage']) ? $user['profileImage'] : './imgs/profile/beard.png' ; ?>" style="width: 200px; height: 200px" class="img rounded-circle" alt="profile">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <form action="Login.php" method="post" enctype="multipart/form-data" id="log-form">

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="email" required name="email" id="email" class="form-control" placeholder="Email*">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="password" required name="password" id="password" class="form-control" placeholder="password*">
                        </div>
                    </div>

                    <div class="submit-btn text-center my-5">
                        <button type="submit" class="btn btn-warning rounded-pill text-dark px-5" name="submit">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>

