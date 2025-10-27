  <?php
  session_start();
  if (!isset($_SESSION['login'])) {
    header('location: index.php');
  }

  require "db.php";
  include "header.php";

  $sql = "SELECT * FROM sell_property";
  $result = mysqli_query($conn, $sql);
  ?>
  <div
    class="hero page-inner overlay"
    style="background-image: url('images/hero_bg_1.jpg')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">Properties</h1>

          <nav
            aria-label="breadcrumb"
            data-aos="fade-up"
            data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li
                class="breadcrumb-item active text-white-50"
                aria-current="page">
                Properties
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row mb-5 align-items-center">
        <div class="col-lg-6 text-center mx-auto">
          <h2 class="font-weight-bold text-primary heading">
            Featured Properties
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="property-slider-wrap">
            <div class="property-slider">

              <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="property-item">
                  <a href="property-single.php?id=<?= $row['id'] ?>&uid=<?= $row['posted_by'] ?>" class="img">
                    <img src="./uploads/<?= $row['picture'] ?>" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <?php if ($row['status'] == "sold") : ?>
                      <img src="./sold.png" alt="" width="50px" style="float: right;">
                    <?php endif; ?>
                    <div class="price mb-2"><span><?= $row['price'] ?></span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"><?= $row['location'] ?></span>
                      <span class="city d-block mb-3"><?= $row['city'] ?></span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption"><?= $row['bedroom'] ?> beds</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <!-- <span class="caption">2 baths</span> -->
                        </span>
                      </div>

                      <a
                        href="property-single.php?id=<?= $row['id'] ?>&uid=<?= $row['posted_by'] ?>"
                        class="btn btn-primary py-2 px-3">See details</a>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>

            </div>
          </div>

          <div
            id="property-nav"
            class="controls"
            tabindex="0"
            aria-label="Carousel Navigation">
            <span
              class="prev"
              data-controls="prev"
              aria-controls="property"
              tabindex="-1">Prev</span>
            <span
              class="next"
              data-controls="next"
              aria-controls="property"
              tabindex="-1">Next</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php include "footer.php"; ?>