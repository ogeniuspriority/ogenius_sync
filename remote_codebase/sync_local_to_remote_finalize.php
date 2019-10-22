<?php
//--------------
//--Count all in table--
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];
$SqlQuery = $_POST['SqlQuery'];

$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);
echo "" . $SqlQuery . "<br/>";


$link = mysqli_connect($host, $user, $password, $dbase);
$stmt = $link->query($SqlQuery);
$theError = mysqli_error($link);
if (strpos($theError, 'Duplicate entry') !== false) {
    echo 'Duplicate entry mehn ' . $theError;
}
if ($stmt) {
    return true;
} else {
    return false;
}
