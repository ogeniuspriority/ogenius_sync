<?php
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];
$SqlQuery = $_POST['SqlQuery'];
//----remote--
$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);
//---
$link = mysqli_connect($host, $user, $password, $dbase);
$stmt = $link->query($SqlQuery);
echo (int) $stmt->num_rows;
//---

