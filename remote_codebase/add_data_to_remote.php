<?php
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];
$Tablename = $_POST['Tablename'];
//----remote--
$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);


$link = mysqli_connect($host, $user, $password, $dbase);
$stmt = $link->query($SqlQuery);
$theError = mysqli_error($link);
if (strpos($theError, 'Duplicate entry') !== false) {
    echo 'Duplicate entry mehn ' . $theError;
}
if ($stmt) {
    echo true;
} else {
    echo false;
}
