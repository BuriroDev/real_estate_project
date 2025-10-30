  <?php
  session_start();
  if (!isset($_SESSION['login'])) {
    header('location: index.php');
  }

  $id = $_GET['id'] ?? "";
  $uid = $_GET['uid'] ?? "";
  $userId = $_SESSION['user_id'];
  $message = "";

  require "db.php";
  include "header.php";

  $sql = "SELECT * FROM sell_property WHERE id = $id";
  $result = mysqli_query($conn, $sql);

  $sql1 = "SELECT * FROM users WHERE id = $uid";
  $userInfo = mysqli_query($conn, $sql1);

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $price = $_POST['price'];
    $property_id = $_POST['product_id'];

    $sql = "SELECT * FROM buy_property WHERE proper_id = $property_id AND buyer = $userId";
    if (mysqli_query($conn, $sql)->num_rows > 0) {
      echo "<script>
            Swal.fire({
            icon: 'info',
            title: 'Offer already sent!',
            text: 'Offer has been sent now wait for seller reply!',
          });
        </script>
        ";
    } else {
      $sql = "INSERT INTO buy_property(buyer, seller, price, proper_id) VALUES($userId, $uid, $price, $property_id)";
      if (mysqli_query($conn, $sql)) {
        header("location: checkout.php");
        //       echo "<script>
        //     Swal.fire({
        //     icon: 'success',
        //     title: 'Offer sent!',
        //     text: 'Buy request has been sent to seller!',
        //   });
        // </script>
        // ";
      }
    }
  }
  ?>
  <!-- /*
* Template Name: Property
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->

  <?php while ($row = $result->fetch_assoc()) : ?>
    <div
      class="hero page-inner overlay"
      style="background-image: url('./images/hero_bg_1.jpg')">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center mt-5">
            <h1 class="heading" data-aos="fade-up">
              <?= $row['location'] ?>
            </h1>

            <nav
              aria-label="breadcrumb"
              data-aos="fade-up"
              data-aos-delay="200">
              <ol class="breadcrumb text-center justify-content-center">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">
                  <a href="properties.php">Properties</a>
                </li>
                <li
                  class="breadcrumb-item active text-white-50"
                  aria-current="page">
                  <?= $row['location'] ?>
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-7">
            <div class="img-property-slide-wrap">
              <div class="img-property-slide">
                <img src="./uploads/<?= $row['picture'] ?>" alt="Image" class="img-fluid" />
              </div>
              <h1 class="text-danger"><?= "Rs." . number_format($row['price'], 2) . "/-"  ?></h1>
              <?php if ($row['status'] != "available") : ?>
                <img src="./sold-out-png-4.png" alt="sold" width="400px">
              <?php endif; ?>  
            </div>
            <div class="col-md-6">
              <?php if ($row['status'] == "available") : ?>
                <form method="POST">
                  <label class="form-label">Price</label>
                  <input type="number" name="price" class="form-control mb-2">
                  <input type="hidden" name="product_id" value='<?= $row['id'] ?>'>
                  <button type="submit" class="btn btn-primary">Buy Request</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-4">
            <h2 class="heading text-primary"><?= $row['location'] ?></h2>
            <p class="meta"><?= $row['city'] ?></p>
            <p class="text-black-50">
              <?= $row['details'] ?>
            </p>
          <?php endwhile; ?>

          <?php while ($row = $userInfo->fetch_assoc()) : ?>
            <div class="d-block agent-box p-5">
              <div class="img mb-4">
                <img
                  src="./uploads/<?= $row['profile'] ?>"
                  alt="Image"
                  class="img-fluid" />
              </div>
              <div class="text">
                <h3 class="mb-0"><?= $row['name'] ?></h3>
                <div class="meta mb-3"><?= $row['occupation'] ?></div>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Ratione laborum quo quos omnis sed magnam id ducimus saepe
                </p>
                <ul class="list-unstyled social dark-hover d-flex">
                  <li class="me-1">
                    <a href="#"><span class="icon-instagram"></span></a>
                  </li>
                  <li class="me-1">
                    <a href="#"><span class="icon-twitter"></span></a>
                  </li>
                  <li class="me-1">
                    <a href="#"><span class="icon-facebook"></span></a>
                  </li>
                  <li class="me-1">
                    <a href="#"><span class="icon-linkedin"></span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>

  <?php include "footer.php"; ?>