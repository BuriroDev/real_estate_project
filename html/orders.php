<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}

require "../db.php";
include "../html/header.php";

$uid = $_SESSION['user_id'];

$sql = "SELECT * FROM buy_property WHERE seller = $uid AND status = 'pending'";
$result = mysqli_query($conn, $sql);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $property = $_GET['property'];

    if ($action === "accept") {
        $sql = "UPDATE buy_property 
                SET status = 'accepted'
                WHERE proper_id = $property;
                ";
        mysqli_query($conn, $sql);

        $sql1 = "UPDATE sell_property
                SET status = 'sold'
                WHERE id = $property;
                ";
        if (mysqli_query($conn, $sql1)) {
            echo "<script>
            Swal.fire({
            icon: 'success',
            title: 'Order Completed',
            text: 'Property has been sold!',
            }).then(() => {
                 window.location.href = 'orders.php'; 
             });
            </script>
        ";
        }
    }
}

if (isset($_GET['reject'])) {
    $property = $_GET['property'];
    $buyer = $_GET['buyer'];

    $sql = "DELETE FROM buy_property 
            WHERE proper_id = $property AND buyer = $buyer
                ";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            Swal.fire({
            icon: 'error',
            title: 'Order Rejected!',
            text: 'Offer has been rejected!',
            }).then(() => {
                 window.location.href = 'orders.php'; 
             });
            </script>
        ";
    }
}
?>

<div class="container">
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6">
            <h2 class="font-weight-bold text-primary heading">
                Orders
            </h2>
        </div>
    </div>

    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Buyer</th>
                <th scope="col">Price</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td scope="row"><?= $row['id'] ?></td>
                    <td scope="row"><?= $row['buyer'] ?></td>
                    <td scope="row"><?= "RS. " . number_format($row['price'], 2) . " PKR" ?></td>
                    <td scope="row"><?= $row['ordered_at'] ?></td>
                    <td scope="row">
                        <a href="orders.php?action=accept&property=<?= $row['proper_id'] ?>" class="btn btn-primary">Accept</a>
                        <a href="orders.php?reject=1&property=<?= $row['proper_id'] ?>&buyer=<?= $row['buyer'] ?>" class="btn btn-danger">Reject</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include "footer.php"; ?>