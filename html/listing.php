<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}

require "../db.php";
include "../html/header.php";

$uid = $_SESSION['user_id'];

$sql = "SELECT s.*, b.price AS sold_price
        FROM sell_property s
        LEFT JOIN buy_property b
        ON s.id = b.proper_id
        WHERE posted_by = $uid";
$result = mysqli_query($conn, $sql);


// $id = $_GET['id'] ?? NULL;

// $sql = "DELETE FROM sell_property WHERE id = '$id'";
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
                        <?php if ($row['status'] == "sold") : ?>
                            <img src="../sold.png" alt="" width="50px" style="margin-left: auto;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['location'] ?></h5>
                            <p class="card-text"><?= $row['details'] ?></p>
                            <p class="card-text"><?= number_format($row['price'], 2) ?> PKR</p>
                            <?php if (!empty($row['sold_price'])) : ?>
                                <p class="card-text"><span class="text-danger">SOLD PRICE: </span> <?= number_format( $row['sold_price'], 2) ?> PKR</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <!-- .item -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>