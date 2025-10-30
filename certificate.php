<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}

$image = imagecreatefrompng('certificate.png');

$textColor = imagecolorallocate($image, 0, 0, 0);

$paid = "RS. " . number_format($_GET['price'],2) . " PKR";
$location = $_GET['location'];
$date = $_GET['date'];
$font = 'ARIAL.TTF';
$fontSize = 15;
$name = $_SESSION['name'];
$seller = $_GET['seller'];

$recipientName = "This certifies that MR. $name has legally brought the property from MR. $seller";
$price = "Paid Price: $paid";
$locationName = "Location: $location";
$completionDate = "Purchase Date: " . $date;

imagettftext($image, $fontSize, 0, 80, 400, $textColor, $font, $recipientName);

imagettftext($image, $fontSize - 4, 0, 80, 450, $textColor, $font, $price);

imagettftext($image, $fontSize - 4, 0, 80, 500, $textColor, $font, $locationName);

imagettftext($image, $fontSize - 6, 0, 80, 550, $textColor, $font, $completionDate);

header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="certificate.png"');

imagepng($image);

imagedestroy($image);
