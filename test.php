<?php
require_once("classes/sync_init.php");
//--------Init this
$appSettingsBluePrint = array();

$appEnvSettings = array();

$appEnvSettings_Operational_level1 = false;
$appEnvSettings_Operational_level2 = false;
$appEnvSettings_Operational_level3 = false;
$appEnvSettings_Operational_level4 = false;
$appEnvSettings_Operational_level5 = false;
$appEnvSettings_Operational_level6 = false;
$appEnvSettings_Operational_level7 = false;
$appEnvSettings_Operational_level8 = false;

$init = new sync_init();

$appSettingsBluePrint = $init->getConfigData();

foreach ($appSettingsBluePrint as $key => $value) {
    # code...
    if (preg_match('#^DATABASE_LOCAL_DB_NAME#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_LOCAL_DB_HOST#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_LOCAL_DB_URL#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_LOCAL_DB_USERNAME#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_LOCAL_DB_PASSWORD#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_REMOTE_DB_NAME#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_REMOTE_DB_HOST#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_REMOTE_DB_URL#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_REMOTE_DB_USERNAME#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_REMOTE_DB_PASSWORD#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    } else if (preg_match('#^DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE#', $value) === 1) {
        // 
        $key = explode("=", $value)[0];
        $val = explode("=", $value)[1];
        $appEnvSettings[$key] = $val;
    }
}
//---SYNC FREQUENCY--
$SYNC_FREQUENCY = (int) rtrim($appEnvSettings["DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE"]);
echo "" . $SYNC_FREQUENCY . "</br>";
//---Detect all configs--
//print_r($appEnvSettings);
//---Step1 see if the .cyumaconfig file is okay--
if (count($appEnvSettings) == 11) {
    echo "<span style='color:green;'>Test 1 passed!</span></br>";
    $appEnvSettings_Operational_level1 = true;
} else {
    echo "<span style='color:red;'>Test 1 failed!</span></br>";
    $appEnvSettings_Operational_level1 = false;
}
//--Detect if local database exists
$appEnvSettings_Operational_level2 = @$init->detectIfLocalDatabaseExists($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD']);
if ($appEnvSettings_Operational_level2) {
    echo "<span style='color:green;'>Test 2 passed!</span></br>";
} else {
    echo "<span style='color:red;'>Test 2 failed!</span></br>";
}
//--Detect if remote database exists
$appEnvSettings_Operational_level3 = @$init->detectIfRemoteDatabaseExists($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD']);
if ($appEnvSettings_Operational_level3) {
    echo "<span style='color:green;'>Test 3 passed!</span></br>";
} else {
    echo "<span style='color:red;'>Test 3 failed!</span></br>";
}
//---See tables in local database;
$appLocalTables = $init->getAllTablesInLocalDatabase($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD']);
print_r($appLocalTables);
if (count($appLocalTables) >= 0) {
    echo "<span style='color:green;'>Test 4 passed!</span></br>";
    $appEnvSettings_Operational_level4 = true;
} else {
    echo "<span style='color:red;'>Test 4 failed!</span></br>";
    $appEnvSettings_Operational_level4 = false;
}
//---See tables in remote database;
$appRemoteTables = $init->getAllTablesInRemoteDatabase($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD']);
print_r($appRemoteTables);
if (count($appRemoteTables) >= 0) {
    echo "<span style='color:green;'>Test 5 passed!</span></br>";
    $appEnvSettings_Operational_level5 = true;
} else {
    echo "<span style='color:red;'>Test 5 failed!</span></br>";
    $appEnvSettings_Operational_level5 = false;
}

//---Count tables on both ends-
if (count($appRemoteTables) == count($appLocalTables)) {
    echo "<span style='color:green;'>Test 6 passed!</span></br>";
    $appEnvSettings_Operational_level6 = true;
} else {
    echo "<span style='color:red;'>Test 6 failed! Number of tables is not the same in both databases. Adjust the situation manually!</span></br>";
    echo "Local database:";
    print_r($appLocalTables);
    echo "Remote database:";
    print_r($appRemoteTables);
    $appEnvSettings_Operational_level6 = false;
}
//----------
/*
[Field] => email
    [Type] => varchar(100)
    [Null] =>
    [Key] =>
    [Default] =>
    [Extra] =>
    --------------------
    $q = mysql_query('DESCRIBE tablename');
while($row = mysql_fetch_array($q)) {
    echo "{$row['Field']} - {$row['Type']}\n";
}
*/
//--Go over local database tables and check each one--
echo "<h4>Local to remote database tables comparisons</h4>";
foreach ($appLocalTables as $key => $value) {
    if (in_array($value, $appRemoteTables)) {
        echo "<span style='color:green;'>Table '$value' Match found in Remote database" . "</span></br>";
        //--
        $appEnvSettings_Operational_level7 = true;
        $tableColumns = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        $tableColumns_remote = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        //----------
        foreach ($tableColumns as $k => $va) {
            # code...
            echo "<div style='margin-top:20px;border-radius:4px;border:1px solid green;max-width:200px;'>";
            echo "<div>Type----" . $va[0] . "</div>";
            if (in_array($va[0], $tableColumns_remote[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[0] . "---<span style='color:green;'>Match</span></div>";
                $appEnvSettings_Operational_level7 = true;
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[0] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level7 = false;
            }
            echo "<div>Null----" . $va[1] . "</div>";
            if (in_array($va[1], $tableColumns_remote[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[1] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[1] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level7 = false;
            }
            echo "<div>Key----" . $va[2] . "</div>";
            if (in_array($va[2], $tableColumns_remote[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[2] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[2] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level7 = false;
            }
            echo "<div>Default----" . $va[3] . "</div>";
            if (in_array($va[3], $tableColumns_remote[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[3] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[3] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level7 = false;
            }
            echo "<div>Extra----" . $va[4] . "</div>";
            if (in_array($va[4], $tableColumns_remote[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level7 = false;
            }
            echo "</div>";
        }
        echo "</br>";
    } else {
        echo "<span style='color:red;'>Table '$value' Match not found in Remote database" . "</span></br>";
    }
}
//--
if ($appEnvSettings_Operational_level7) {
    echo "<div style='color:green;'>Step Succeeded!</div>";
} else {
    echo "<div style='color:red;'>Step Failed!</div>";
}
//--Go over local database tables and check each one--
echo "<h4>Remote to local database tables comparisons</h4>";
foreach ($appRemoteTables as $key => $value) {
    if (in_array($value, $appLocalTables)) {
        echo "<span style='color:green;'>Table '$value' Match found in Local database" . "</span></br>";
        $tableColumns = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        $tableColumns_remote = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        $appEnvSettings_Operational_level8 = true;
        foreach ($tableColumns_remote as $k => $va) {
            # code...
            echo "<div style='margin-top:20px;border-radius:4px;border:1px solid green;max-width:200px;'>";
            echo "<div>Type----" . $va[0] . "</div>";
            if (in_array($va[0], $tableColumns[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[0] . "---<span style='color:green;'>Match</span></div>";
                $appEnvSettings_Operational_level8 = true;
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[0] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level8 = false;
            }
            echo "<div>Null----" . $va[1] . "</div>";
            if (in_array($va[1], $tableColumns[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[1] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[1] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level8 = false;
            }
            echo "<div>Key----" . $va[2] . "</div>";
            if (in_array($va[2], $tableColumns[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[2] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[2] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level8 = false;
            }
            echo "<div>Default----" . $va[3] . "</div>";
            if (in_array($va[3], $tableColumns[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[3] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[3] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level8 = false;
            }
            echo "<div>Extra----" . $va[4] . "</div>";
            if (in_array($va[4], $tableColumns[$k])) {
                echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:green;'>Match</span></div>";
            } else {
                echo "<div style='margin-left:50px;'>Type----" . $va[4] . "---<span style='color:red;'>No Match</span></div>";
                $appEnvSettings_Operational_level8 = false;
            }
            echo "</div>";
        }
        echo "</br>";
    } else {
        echo "<span style='color:red;'>Table '$value' Match not found in Local database" . "</span></br>";
    }
}
//--
if ($appEnvSettings_Operational_level8) {
    echo "<div style='color:green;'>Step Succeeded!</div>";
} else {
    echo "<div style='color:red;'>Step Failed!</div>";
}
//------Sync data from local to remote database
foreach ($appLocalTables as $key => $value) {
    if (in_array($value, $appRemoteTables)) {
        //echo "<span style='color:green;'>Table '$value' Match found in Remote database" . "</span></br>";
        //--
        //$tableColumns = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        //$tableColumns_remote = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        //----------Paginate the data---also select until u find nothing--
        //---Find in confict latest id count to start from when selecting and counting--
        $countRowsInLocal = $init->count_rows($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        //---Divide them into steps.---
        if ($countRowsInLocal > 0) {
            echo "<div>Table:$value Nber of rows in total " . $countRowsInLocal . " <span style='color:green'> It can attempt sync!</span></div>";
            //---------Get All the data from the table and compare -- start with last id in config until that id olus frequency
            $RowsInLocal = $init->getAllDataInThisTable($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
            //print_r($RowsInLocal);
            //----------            
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
                $occurenceInRemoteDatabase = $init->runQueryAndCount($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $track_records_query);
                if ((int) $occurenceInRemoteDatabase <= 0) {
                    echo "Occurence can be synced $occurenceInRemoteDatabase<br/>";
                    //-----
                    if ($init->addLocalTableToRemoteTable($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $track_records_query_INSERT_FIELDS)) {
                        echo "SYnced";
                    } else {
                        echo " Not SYnced";
                    }
                } else { }
            }
            //----Prepare sql for check 
        } else { }
    } else {
        //echo "<span style='color:red;'>Table '$value' Match not found in Remote database" . "</span></br>";
    }
}
//------Sync data from remote  to local database
foreach ($appRemoteTables as $key => $value) {
    if (in_array($value, $appLocalTables)) {
        //echo "<span style='color:green;'>Table '$value' Match found in Local database" . "</span></br>";
        //$tableColumns = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $value);
        // $tableColumns_remote = $init->getThisDatabaseTableStructure($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        $countRowsInLocal = $init->count_rows($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
        //---Divide them into steps.---
        if ($countRowsInLocal > 0) {
            echo "<div>Table:$value Nber of rows in total " . $countRowsInLocal . " <span style='color:green'> It can attempt sync!</span></div>";
            //---------Get All the data from the table and compare -- start with last id in config until that id olus frequency
            $RowsInLocal = $init->getAllDataInThisTable($appEnvSettings['DATABASE_REMOTE_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_REMOTE_DB_URL'],  $appEnvSettings['DATABASE_REMOTE_DB_PASSWORD'], $value);
            //print_r($RowsInLocal);
            //----------            
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
                $occurenceInRemoteDatabase = $init->runQueryAndCount($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_REMOTE_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $track_records_query);
                if ((int) $occurenceInRemoteDatabase <= 0) {
                    echo "Occurence can be synced $occurenceInRemoteDatabase<br/>";
                    //-----
                    if ($init->addLocalTableToRemoteTable($appEnvSettings['DATABASE_LOCAL_DB_NAME'], $appEnvSettings['DATABASE_LOCAL_DB_USERNAME'], $appEnvSettings['DATABASE_LOCAL_DB_URL'],  $appEnvSettings['DATABASE_LOCAL_DB_PASSWORD'], $track_records_query_INSERT_FIELDS)) {
                        echo "SYnced";
                    } else {
                        echo " Not SYnced";
                    }
                } else { }
            }
            //----Prepare sql for check 
        } else { }
    } else {
        //echo "<span style='color:red;'>Table '$value' Match not found in Local database" . "</span></br>";
    }
}
/*
$data = file('myfile'); // reads an array of lines
function replace_a_line($data) {
   if (stristr($data, 'certain word')) {
     return "replaement line!\n";
   }
   return $data;
}
$data = array_map('replace_a_line',$data);
file_put_contents('myfile', implode('', $data));
*/
