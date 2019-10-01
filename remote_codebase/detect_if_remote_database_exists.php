<?php
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];

$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);


$con = mysqli_connect($host, $user, $password, $dbase);

// Check connection
if (mysqli_connect_errno()) {
    //echo "Failed to connect to MySQL: " . mysqli_connect_error();
    echo false;
} else {
    echo true;
}
