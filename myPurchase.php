<?php
session_start();
if (!isset($_SESSION['login'])) {

    header('location: index.php');
}

require "db.php";
include "header.php";

$uid = $_SESSION['user_id'];
echo $uid;

$sql = "SELECT s.location, s.details, s.picture, s.status, s.id
        FROM sell_property s
        INNER JOIN buy_property b
        ON b.proper_id = s.id
        WHERE b.buyer = $uid AND b.status = 'accepted';";
$result = mysqli_query($conn, $sql);
?>

<div class="section mt-5">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="font-weight-bold text-primary heading">
                    Your Purchases
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex gap-5 flex-wrap">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="./uploads/<?= $row['picture'] ?>" alt="Card image cap">
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