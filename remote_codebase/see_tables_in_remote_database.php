<?php
header("Access-Control-Allow-Origin: *");
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];

$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);


$link = mysqli_connect($host, $user, $password, $dbase);
$output = array();
if ($stmt = $link->query("SHOW TABLES")) {
    //echo "No of records : " . $stmt->num_rows . "<br>";
    while ($row = $stmt->fetch_array()) {
        //echo $row[0] . "<br>";
        $output[] = $row[0];
    }
    //return $output;
    $myJSON = json_encode($output);
    echo $myJSON;
} else {
    echo $link->error;
}
