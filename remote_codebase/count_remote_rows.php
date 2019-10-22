<?php
header("Access-Control-Allow-Origin: *");
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
$stmt = $link->query("SELECT * FROM $Tablename");
echo (int) $stmt->num_rows;
