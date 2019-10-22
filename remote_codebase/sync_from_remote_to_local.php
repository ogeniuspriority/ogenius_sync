<?php
//--------------
//--Count all in table--
$remoteDomainUrlForFiles = $_POST['remoteDomainUrlForFiles'];

function count_rows($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);
    //------


    $link = mysqli_connect($host, $user, $password, $dbase);
    $stmt = $link->query("SELECT * FROM $Tablename");
    return (int) $stmt->num_rows;
}
//--
function count_rows_REMOTE($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);
    //------

    $post = [
        'DatabaseUser' => $user,
        'Password' => $password,
        'Host'   => $host,
        'DatabaseName'   => $dbase,
        'Tablename'   => $Tablename,
    ];

    $ch = curl_init($GLOBALS["remoteDomainUrlForFiles"] . 'remote_codebase/count_remote_rows.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//-
//---Find Run this query and return count
function runQueryAndCount($DatabaseName, $DatabaseUser, $Host, $Password, $SqlQuery)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);


    $link = mysqli_connect($host, $user, $password, $dbase);
    $stmt = $link->query($SqlQuery);
    return (int) $stmt->num_rows;
}
//--
function runQueryAndCount_REMOTE($DatabaseName, $DatabaseUser, $Host, $Password, $SqlQuery)
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
        'SqlQuery'   => $SqlQuery,
    ];

    $ch = curl_init($GLOBALS["remoteDomainUrlForFiles"] . 'remote_codebase/run_remote_query.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//---Add local row to remote table
function addLocalTableToRemoteTable($DatabaseName, $DatabaseUser, $Host, $Password, $SqlQuery)
{
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
}
//---
function addLocalTableToRemoteTable_REMOTE($DatabaseName, $DatabaseUser, $Host, $Password, $SqlQuery)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);
    //echo "" . $SqlQuery . "<br/>";


    $post = [
        'DatabaseUser' => $user,
        'Password' => $password,
        'Host'   => $host,
        'DatabaseName'   => $dbase,
        'SqlQuery'   => $SqlQuery,
    ];

    $ch = curl_init($GLOBALS["remoteDomainUrlForFiles"] . 'remote_codebase/sync_local_to_remote_finalize.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//--Get all Data in one table
function getAllDataInThisTable($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
{
    $user = rtrim($DatabaseUser);
    $password = rtrim($Password);
    $host = rtrim($Host);
    $dbase = rtrim($DatabaseName);


    $link = mysqli_connect($host, $user, $password, $dbase);
    $output = array();
    if ($stmt = $link->query("SELECT * FROM  $Tablename")) {
        //echo "No of records : " . $stmt->num_rows . "<br>";
        while ($row = $stmt->fetch_array()) {
            $output[] = $row;
        }
        return $output;
    } else {
        echo $link->error;
    }
    return $output;
}
//--
function getAllDataInThisTable_REMOTE($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
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

    $ch = curl_init($GLOBALS["remoteDomainUrlForFiles"] . 'remote_codebase/get_all_data_in_remote_table.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//---Find rows occurrence in remote database//--
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

    $ch = curl_init($GLOBALS["remoteDomainUrlForFiles"] . 'remote_codebase/get_table_structure_remotely.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    return $response;
}
//--
$SYNC_FREQUENCY = $_POST['DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE'];
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
$SYNC_FREQUENCY = rtrim($SYNC_FREQUENCY);
//-------------
$tablesInLocalDB = json_decode($tablesInLocalDB);
$tablesInRemoteDB = json_decode($tablesInRemoteDB);


//------Sync data from remote  to local database
foreach ($tablesInLocalDB as $key => $value) {
    if (in_array($value, $tablesInRemoteDB)) {
        //echo "<span style='color:green;'>Table '$value' Match found in Local database" . "</span></br>";
        //$tableColumns = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        // $tableColumns_remote = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        $countRowsInLocal = count_rows($dbase, $user, $host,  $password, $value);
        //---Divide them into steps.---
        if ($countRowsInLocal > 0) {
            echo "Table:$value Nber of rows in total " . $countRowsInLocal . " It can attempt sync!" . PHP_EOL;
            //---------Get All the data from the table and compare -- start with last id in config until that id olus frequency
            $RowsInLocal =  getAllDataInThisTable($dbase, $user, $host,  $password, $value);
            //print_r($RowsInLocal);
            //----------     
            //$RowsInLocal = unserialize($RowsInLocal);
            foreach ($RowsInLocal as $ky => $vae) {
                # 
                $track_records_query = "";
                $track_records_query_INSERT_FIELDS = "";
                $track_records_query_INSERT_FIELDS_DATA = "";
                $count_t_009 = 0;
                foreach ($vae as $k00 => $v00) {
                    # code...     
                    if ((int) $k00 > 0 || $k00 == "0") {
                        continue;
                    }
                    //--
                    if ($count_t_009 == 0) {
                        $track_records_query .= " SELECT * FROM $value WHERE " . $k00 . "='$v00'";
                        //---INSERT BLUEPRINT-
                        $track_records_query_INSERT_FIELDS .= "INSERT INTO $value ($k00 ";
                        $track_records_query_INSERT_FIELDS_DATA .= " VALUES ('$v00' ";
                    } else {
                        $track_records_query .= " AND " . $k00 . "='$v00'";
                        //---INSERT BLUEPRINT-
                        $track_records_query_INSERT_FIELDS .= ",$k00 ";
                        $track_records_query_INSERT_FIELDS_DATA .= ",'$v00'";
                    }
                    //----                    
                    $count_t_009++;
                }
                //--
                $track_records_query_INSERT_FIELDS .= ")";
                $track_records_query_INSERT_FIELDS_DATA .= ")";
                //--
                $track_records_query_INSERT_FIELDS .= $track_records_query_INSERT_FIELDS_DATA;
                //echo "" . $track_records_query_INSERT_FIELDS . "</br>";
                $track_records_query .= "  LIMIT " . $SYNC_FREQUENCY;
                //----Search if the the record exists in remote database if not add it-----
                $occurenceInRemoteDatabase = runQueryAndCount_REMOTE($dbase_REMOTE, $user_REMOTE, $host_REMOTE,  $password_REMOTE, $track_records_query);
                if ((int) $occurenceInRemoteDatabase <= 0) {
                    echo "Occurence can be synced $occurenceInRemoteDatabase" . PHP_EOL;
                    //-----
                    if (addLocalTableToRemoteTable_REMOTE($dbase_REMOTE, $user_REMOTE, $host_REMOTE,  $password_REMOTE, $track_records_query_INSERT_FIELDS)) {
                        echo "SYnced Remote To Local ";
                    } else {
                        echo " Not SYnced Remote to Local";
                    }
                } else { }
            }
            //----Prepare sql for check 
        } else { }
    } else {
        //echo "<span style='color:red;'>Table '$value' Match not found in Local database" . "</span></br>";
    }
}
