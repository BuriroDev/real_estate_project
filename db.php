<?php
$localhost = "localhost";
$username = "root";
$password = "root";
$db_name = "real_estate_management";

$conn = new mysqli($localhost, $username, $password, $db_name);

if($conn->connect_error){
    echo "failed to connect";
}
?>