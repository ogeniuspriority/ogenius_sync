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
$output = array();
if ($stmt = $link->query("SHOW COLUMNS FROM  $Tablename")) {
    //echo "No of records : " . $stmt->num_rows . "<br>";
    while ($row = $stmt->fetch_array()) {
        $output[] = $row;
    }


    echo serialize($output);
} else {
    echo $link->error;
}
