<?php
require_once("../classes/sync_init.php");

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

$init = new sync_init("../.cyumaconfig");

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

//---------------
$myJSON = json_encode($appEnvSettings);

echo $myJSON;
