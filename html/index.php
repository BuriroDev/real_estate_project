<?php
session_start();
if (!isset($_SESSION['login'])) {
  header('location: ../index.php');
}

include "../html/header.php";
require "../db.php";

$uid = $_SESSION['user_id'];

$sold_sql = "SELECT COUNT(*) AS TOTAL FROM sell_property WHERE status = 'sold' AND posted_by = $uid";
$result = mysqli_query($conn, $sold_sql)->fetch_assoc();
$sold = $result['TOTAL'];

$avail_sql = "SELECT COUNT(*) AS STILL FROM sell_property WHERE status = 'available' AND posted_by = $uid";
$result1 = mysqli_query($conn, $avail_sql)->fetch_assoc();
$avail = $result1['STILL'];

$profit_sql = "SELECT SUM(price) AS TOTAL_SOLD FROM buy_property WHERE status = 'accepted' AND seller = $uid";
$result3 = mysqli_query($conn, $profit_sql)->fetch_assoc();
$totalSale = $result3['TOTAL_SOLD'] ?? 0;

$top_clients = "SELECT u.*, b.*, b.price AS sold_price, s.*
                FROM buy_property b 
                INNER JOIN users u
                ON b.buyer = u.id
                INNER JOIN sell_property s
                ON b.proper_id = s.id
                WHERE b.seller = $uid AND b.status = 'accepted'
                ";

$topUsers = mysqli_query($conn, $top_clients);
?>
<div class="row mb-5 align-items-center">
  <div class="col-lg-6">
    <h2 class="font-weight-bold text-primary heading">
      Dashboard
    </h2>
  </div>
</div>
<!--  Row 1 -->
<div class="d-flex gap-5">
  <div class="row">
    <div class="row">
      <div class="col-lg-12 col-sm-6">
        <!-- Yearly Breakup -->
        <div class="card overflow-hidden">
          <div class="card-body p-4">
            <h5 class="card-title mb-10 fw-semibold">Total Sale</h5>
            <div class="row align-items-center">
              <div class="col-7">
                <h4 class="fw-semibold mb-3">RS. <?= number_format($totalSale, 2) ?> PKR</h4>
                <div class="d-flex align-items-center mb-2">
                  <span
                    class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-up-left text-success"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">last year</p>
                </div>
              </div>
              <div class="col-5">
                <div class="d-flex justify-content-center">
                  <div id="grade"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-sm-6">
        <!-- Yearly Breakup -->
        <div class="card overflow-hidden">
          <div class="card-body p-4">
            <h5 class="card-title mb-10 fw-semibold">Properties Sold</h5>
            <div class="row align-items-center">
              <div class="col-7">
                <h4 class="fw-semibold mb-3"><?= $sold ?></h4>
                <div class="d-flex align-items-center mb-2">
                </div>
              </div>
              <div class="col-5">
                <div class="d-flex justify-content-center">
                  <div id="grade"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-sm-6">
        <!-- Yearly Breakup -->
        <div class="card overflow-hidden">
          <div class="card-body p-4">
            <h5 class="card-title mb-10 fw-semibold">Properties Available</h5>
            <div class="row align-items-center">
              <div class="col-7">
                <h4 class="fw-semibold mb-3"><?= $avail ?></h4>
                <div class="d-flex align-items-center mb-2">
                </div>
              </div>
              <div class="col-5">
                <div class="d-flex justify-content-center">
                  <div id="grade"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-8 d-flex align-items-stretch">
    <div class="card w-100">
      <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
          <h5 class="mb-0 fw-bold">Recently Purchased Clients</h5>

          <div class="dropdown">
            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
              class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
              <i class="ti ti-dots-vertical fs-7 d-block"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li>
                <a class="dropdown-item" href="#">Another action</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="table-responsive" data-simplebar>
          <table class="table table-borderless align-middle text-nowrap">
            <thead>
              <tr>
                <th scope="col">Profile</th>
                <th scope="col">Name</th>
                <th scope="col">Occupation</th>
                <th scope="col">Property Location</th>
                <th scope="col">Sold Price</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $topUsers->fetch_assoc()) : ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="me-4">
                        <img src="../uploads/<?= $row['profile'] ?>" width="50" class="rounded-circle"
                          alt="" />
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="fs-3 fw-normal mb-0"><?= $row['name'] ?></p>
                  </td>
                  <td>
                    <p>
                      <?= $row['occupation'] ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?= $row['location'] ?>
                    </p>
                  </td>
                  <td>
                    <p class="fs-3 fw-normal mb-0 text-danger">
                      <?= $row['sold_price'] ?>
                    </p>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "../html/footer.php"; ?>