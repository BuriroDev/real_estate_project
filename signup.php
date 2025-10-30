<?php
require "db.php";
include "./header.php";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    //PERSONAL DETAILS
    $name = $_POST['name'];
    $occupation = $_POST['occupation'];
    $city = $_POST['city'];

    $originalName = basename($_FILES['photo']['name']);
    $fileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png'];

    $photoName = time() . '_' . $originalName;
    $uploadDir = 'uploads/';
    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);

    //CREDENTIALS
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $protectedPassword = md5($password);
    $role = $_POST['role'];

    $checkUser = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = mysqli_query($conn, $checkUser);

    if ($result->num_rows > 0) {
        echo "<script>
            Swal.fire({
            icon: 'error',
            title: 'Username Already Taken!',
            text: 'Please try another username.',
          });
        </script>
        ";
    } else {
        if ($password === $confirmPassword) {
            $emp_sql = "INSERT INTO users(name, occupation, city, profile) VALUES('$name', '$occupation', '$city', '$photoName')";
            mysqli_query($conn, $emp_sql);

            $id = $conn->insert_id;

            $sql = "INSERT INTO user_credentials(username, password, role, user_id) VALUES('$username', '$protectedPassword', '$role', $id)";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
            Swal.fire({
            icon: 'success',
            title: 'Account Created!',
            text: 'User have been registered.',
            }).then(() => {
                window.location.href = 'index.php'; 
            });
        </script>
        ";
            }
        } else {
            echo "<script>
            Swal.fire({
            icon: 'info',
             title: 'Password did match!',
             text: 'Please enter both passwords correctly',
         }).then(() => {
             window.location.href = 'signup.php'; 
         });
        </script>
        ";
        }
    }
}
?>

<div class="bg-gradient-primary">
    
    <div class="container" style="margin-top: 100px;">
        <a href="index.php" class="btn btn-secondary">Back</a>

        <!-- Centered Form -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5" style="margin-top: 10px;">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" enctype="multipart/form-data" class="user">
                            <div class="form-group mb-2">
                                <label>Name:</label>
                                <input type="text" class="form-control form-control-user"
                                    placeholder="Enter your Name...." name="name" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Occupation:</label>
                                <input type="text" class="form-control form-control-user"
                                    placeholder="Enter your Occupation...." name="occupation" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>City:</label>
                                <input type="text" class="form-control form-control-user"
                                    placeholder="Enter your City...." name="city" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Profile Photo:</label>
                                <input type="file" class="form-control form-control-user"
                                    name="photo">
                            </div>
                            <hr>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control form-control-user"
                                    placeholder="Set Username" name="username" required>
                            </div>
                            <div class="form-group mb-2">
                                <input type="password" class="form-control form-control-user"
                                    placeholder="Set Password" name="password" required>
                            </div>
                            <div class="form-group mb-2">
                                <input type="password" class="form-control form-control-user"
                                    placeholder="Confirm Password" name="confirmPassword" required>
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control" name="role" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="seller">Seller</option>
                                    <option value="buyer">Buyer</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account!
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="index.php">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "./footer.php";
    ?>