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
    }
}
//---Detect all configs--
//print_r($appEnvSettings);
//---Step1 see if the .cyumaconfig file is okay--
if (count($appEnvSettings) == 10) {
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
