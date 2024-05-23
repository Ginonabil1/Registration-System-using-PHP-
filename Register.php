<?php
include 'header.php';
include 'Database.php';
    session_start();

   if(isset($_SESSION["fname"])){   
     header("Location: login.php");
   }
if (isset($_POST["submit"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $cpass = $_POST["cpassword"];
    $profileImage = "";

    if ($pass == $cpass) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0) {
            // Process the image upload
            if (isset($_FILES["ProfileUpload"]) && $_FILES["ProfileUpload"]["error"] == 0) {
                $target_dir = "./imgs/profile/";
                $target_file = $target_dir . basename($_FILES["ProfileUpload"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $uploadOk = 1;
                $errorMsg = "";

                // Check if file is an actual image
                $check = getimagesize($_FILES["ProfileUpload"]["tmp_name"]);
                if ($check === false) {
                    $errorMsg = "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["ProfileUpload"]["size"] > 600000) {
                    $errorMsg = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["ProfileUpload"]["tmp_name"], $target_file)) {
                        $profileImage = $target_file; // Store the image URL
                    } else {
                        $errorMsg = "Sorry, there was an error uploading your file.";
                        $uploadOk = 0;
                    }
                }

                if ($uploadOk == 0) {
                    echo "<script>alert('$errorMsg')</script>";
                }
            }

                $sql = "INSERT INTO users (FirstName, LastName, email, password, profileImage) 
                        VALUES ('$fname', '$lname', '$email', '$pass', '$profileImage')";

                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>alert('Registered successfully..!')</script>";
                    $fname = "";
                    $lname = "";
                    $email = "";
                    $_POST["password"] = "";
                    $_POST["cpassword"] = "";
                    header("Location:login.php");
                } else {
                    echo "<script>alert('Something went wrong')</script>";
                }
            
        } else {
            echo "<script>alert('Email already exists')</script>";
        }
    } else {
        echo "<script>alert('Password not matched')</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<body>
    <section id="Register">
        <div class="row m-0">
            <div class="col-lg-4 offset-lg-2">
                <div class="text-center pb-4">
                    <h1 class="login_title">Register</h1>
                    <p class="p-1 m-0 text-black-50">Register and enjoy additional features</p>
                    <span>I already have <a href="Login.php" class="text-decoration-none">Login</a></span>
                </div>
                <div class="upload_img d-flex justify-content-center pb-3">
                    <div class="text-center">
                        <div class="d-flex justify-content-center">
                            <img class="camera" src="imgs/camera-solid.svg" alt="camera">
                        </div>
                        <img src="imgs/profile/beard.png" alt="pic" width="200px" height="200px" class="img rounded-circle">
                        <p class="text-black-50">choose image(optional)</p>
                        <input type="file" form="reg-form" class="form-control-file d-flex justify-content-center" name="ProfileUpload" id="upload_pr">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <form action="#" method="post" id="reg-form" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" name="fname" placeholder="First Name" id="fname" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="lname" placeholder="Last Name" id="lname" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="my-4">
                                    <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
                                </div>
                                <div class="my-4">
                                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                                </div>
                                <div class="my-4">
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" id="cpassword" required>
                                    <small id="confirm_error" class="text-danger"></small>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="agreement" class="form-check-input" required>
                                    <label for="agreement" class="form-check-label text-black-50">I agree <span style="color:blue;">term, conditions, and policy(*)</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="submit-btn text-center my-5">
                            <button type="submit" class="btn btn-warning rounded-pill text-dark px-5" name="submit">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
