<?php
$tablesInLocalDB = $_POST['tablesInLocalDB'];
$tablesInRemoteDB = $_POST['tablesInRemoteDB'];

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
