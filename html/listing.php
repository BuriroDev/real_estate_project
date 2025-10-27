<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}

require "../db.php";
include "../html/header.php";

$uid = $_SESSION['user_id'];

$sql = "SELECT * FROM sell_property WHERE posted_by = $uid";
$result = mysqli_query($conn, $sql);


$id = $_GET['id'] ?? NULL;

$sql = "DELETE FROM sell_property WHERE id = '$id'";
?>

<div class="section">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="font-weight-bold text-primary heading">
                    Your Listings
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex gap-5 flex-wrap">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="../uploads/<?= $row['picture'] ?>" alt="Card image cap">
                        <?php if($row['status'] == "sold") : ?>
                            <img src="../sold.png" alt="" width="50px" style="float: right;">
                        <?php endif; ?>    
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['location'] ?></h5>
                            <p class="card-text"><?= $row['details'] ?></p>
                            <a href="listing.php?id=<?= $row['id'] ?>" class="btn btn-primary">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
                <!-- .item -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>