<?php
//--------------
function getThisDatabaseTableStructure($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
{
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
        return $output;
    } else {
        echo $link->error;
    }
}
//--
function getThisDatabaseTableStructure_curl_post($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);


    $post = [
        'DatabaseUser' => $user,
        'Password' => $password,
        'Host'   => $host,
        'DatabaseName'   => $dbase,
        'Tablename'   => $Tablename,
    ];

    $ch = curl_init('http://localhost/ogenius_sync/remote_codebase/get_table_structure_remotely.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//--------------------------------------
$tablesInLocalDB = $_POST['tablesInLocalDB'];
$tablesInRemoteDB = $_POST['tablesInRemoteDB'];
$DatabaseUser = $_POST['DatabaseUser'];
$Password = $_POST['Password'];
$Host = $_POST['Host'];
$DatabaseName = $_POST['DatabaseName'];
//----remote--
$DatabaseUser_REMOTE = $_POST['DatabaseUser_REMOTE'];
$Password_REMOTE = $_POST['Password_REMOTE'];
$Host_REMOTE = $_POST['Host_REMOTE'];
$DatabaseName_REMOTE = $_POST['DatabaseName_REMOTE'];
//-----------
$user_REMOTE = rtrim($DatabaseUser_REMOTE);
$password_REMOTE = rtrim($Password_REMOTE);
$host_REMOTE = rtrim($Host_REMOTE);
$dbase_REMOTE = rtrim($DatabaseName_REMOTE);
//----------------
$user = rtrim($DatabaseUser);
$password = rtrim($Password);
$host = rtrim($Host);
$dbase = rtrim($DatabaseName);
//-------------
$tablesInLocalDB = json_decode($tablesInLocalDB);
$tablesInRemoteDB = json_decode($tablesInRemoteDB);

foreach ($tablesInLocalDB as $key => $value) {
    if (in_array($value, $tablesInRemoteDB)) {
        echo "Table '$value' Match found in Remote database" . PHP_EOL;
        //--
        $tableColumns = getThisDatabaseTableStructure($DatabaseName, $DatabaseUser, $Host,  $Password, $value);
        $tableColumns_remote = getThisDatabaseTableStructure_curl_post($DatabaseName_REMOTE, $DatabaseUser_REMOTE, $Host_REMOTE,  $Password_REMOTE, $value);
        //print_r($tableColumns_remote);
        $tableColumns_remote = $array = unserialize($tableColumns_remote);
        //----------        
        foreach ($tableColumns as $k => $va) {
            # code...          
            if (in_array($va[0], $tableColumns_remote[$k])) {
                echo "Type----" . $va[0] . "---Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = true;
            } else {
                echo "Type----" . $va[0] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Null----" . $va[1] . "</div>";
            if (in_array($va[1], $tableColumns_remote[$k])) {
                echo "Type----" . $va[1] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[1] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Key----" . $va[2] . "</div>";
            if (in_array($va[2], $tableColumns_remote[$k])) {
                echo "Type----" . $va[2] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[2] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Default----" . $va[3] . "</div>";
            if (in_array($va[3], $tableColumns_remote[$k])) {
                echo "Type----" . $va[3] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[3] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Extra----" . $va[4] . "</div>";
            if (in_array($va[4], $tableColumns_remote[$k])) {
                //echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "Type----" . $va[4] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "</div>";
        }
        //echo "</br>";
    } else {
        echo "'>Table '$value' Match not found in Remote database" . PHP_EOL;
    }
}
//--------tablesInRemoteDB---tablesInLocalDB
foreach ($tablesInRemoteDB as $key => $value) {
    if (in_array($value, $tablesInLocalDB)) {
        echo "Table '$value' Match found in Remote database" . PHP_EOL;
        //--
        $tableColumns = getThisDatabaseTableStructure($DatabaseName, $DatabaseUser, $Host,  $Password, $value);
        $tableColumns_remote = getThisDatabaseTableStructure_curl_post($DatabaseName_REMOTE, $DatabaseUser_REMOTE, $Host_REMOTE,  $Password_REMOTE, $value);
        //print_r($tableColumns_remote);
        $tableColumns_remote = $array = unserialize($tableColumns_remote);
        //----------        
        foreach ($tableColumns_remote as $k => $va) {
            # code...          
            if (in_array($va[0], $tableColumns[$k])) {
                echo "Type----" . $va[0] . "---Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = true;
            } else {
                echo "Type----" . $va[0] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Null----" . $va[1] . "</div>";
            if (in_array($va[1], $tableColumns[$k])) {
                echo "Type----" . $va[1] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[1] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Key----" . $va[2] . "</div>";
            if (in_array($va[2], $tableColumns[$k])) {
                echo "Type----" . $va[2] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[2] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Default----" . $va[3] . "</div>";
            if (in_array($va[3], $tableColumns[$k])) {
                echo "Type----" . $va[3] . "---Match" . PHP_EOL;
            } else {
                echo "Type----" . $va[3] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "<div>Extra----" . $va[4] . "</div>";
            if (in_array($va[4], $tableColumns[$k])) {
                //echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "Type----" . $va[4] . "---No Match" . PHP_EOL;
                //$appEnvSettings_Operational_level7 = false;
            }
            //echo "</div>";
        }
        //echo "</br>";
    } else {
        echo "'Table '$value' Match not found in Remote database" . PHP_EOL;
    }
}
