<?php
session_start();
require "db.php";
if(isset($_SESSION['login'])){
    header("location: home.php");
}

include "./header.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $checkUser = "SELECT uc.username, uc.password, uc.role, u.name, u.occupation, u.city, u.profile, u.id
                  FROM user_credentials uc
                  INNER JOIN users u
                  ON uc.user_id = u.id
                  WHERE uc.username = '$username' && uc.password = '$password'";

    $result = mysqli_query($conn, $checkUser);

    if ($result->num_rows > 0) {
        $_SESSION['login'] = 1;

        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['profile'] = $row['profile'];

        if ($row['role'] === "seller") {
            header("location: html/index.php");
        }else{
            header("location: home.php");
        }

    } else {
        echo "<script>
            Swal.fire({
  icon: 'error',
  title: 'Invalid Credentials!',
  text: 'Please Try Again.',
});
        </script>
        ";
    }
}

?>

<body class="bg-gradient-primary">
    <div class="container">

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center" id="login-alert">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Centered Row -->
        <div id="mainDiv" class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form method="POST" class="user">
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control form-control-user" name="username" placeholder="Enter Username..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password" id="myInput" placeholder="Enter Password..." required>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe" name="rememberme">
                                        <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block mt-2">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="../public/forgot-password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="signup.php">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "./footer.php";
    ?>