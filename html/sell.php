<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}

require "../db.php";
include "../html/header.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    //PERSONAL DETAILS
    $location = $_POST['location'];
    $bedrooms = $_POST['bedrooms'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $details = $_POST['details'];
    $id = $_SESSION['user_id'];


    if (isset($_FILES['pictures']) && $_FILES['pictures']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['pictures']['name']);
        $fileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        $photoName = time() . '_' . $originalName;
        $uploadDir = '../uploads/';
        move_uploaded_file($_FILES['pictures']['tmp_name'], $uploadDir . $photoName);
    }

    $emp_sql = "INSERT INTO sell_property(location, bedroom, area, price, city, details, picture, posted_by) VALUES('$location', $bedrooms, $area, $price, '$city', '$details', '$photoName', $id)";

    if (mysqli_query($conn, $emp_sql)) {
        echo "<script>
            Swal.fire({
            icon: 'success',
            title: 'Bid Posted!',
            text: 'You bid has been placed.',
          });
        </script>
        ";
    }
}


?>
<div class="row mb-5 align-items-center">
    <div class="col-lg-6">
        <h2 class="font-weight-bold text-primary heading">
            List your Property
        </h2>
    </div>
</div>

<form method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Bedrooms</label>
        <input type="number" name="bedrooms" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Area</label>
        <input type="number" name="area" class="form-control" placeholder="Measurement in Feet">
    </div>
    <div class="col-12">
        <label class="form-label">Price</label>
        <input type="number" name="price" class="form-control" placeholder="In PKR">
    </div>
    <div class="col-md-6">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Details</label>
        <input type="textarea" name="details" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Pictures:</label>
        <input type="file" name="pictures" class="form-control">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">POST</button>
    </div>
</form>


<?php include "../html/footer.php"; ?>