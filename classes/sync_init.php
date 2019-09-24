<?php
class sync_init
{
    // Declare  properties
    public $global_settings = array();
    //---
    function __construct($fileLoc)
    {
        $block = 1024 * 1024; //1MB or counld be any higher than HDD block_size*2
        if ($fh = fopen($fileLoc, "r")) {
            $left = '';
            while (!feof($fh)) { // read the file
                $temp = fread($fh, $block);
                $fgetslines = explode("\n", $temp);
                $fgetslines[0] = $left . $fgetslines[0];
                if (!feof($fh)) $left = array_pop($lines);
                foreach ($fgetslines as $k => $line) {
                    //do smth with $line
                    //echo "" . $line . "</br>";
                    /*if($this->global_settings==""){
                        $this->global_settings=$line;
                    }else{
                        $this->global_settings=$this->global_settings."~~".$line;
                    }*/
                    array_push($this->global_settings, $line);
                }
            }
        }
        fclose($fh);
        //----
    }
    //---The config data
    function getConfigData()
    {
        return $this->global_settings;
    }
    //---Detect if local database exists
    function detectIfLocalDatabaseExists($DatabaseName, $DatabaseUser, $Host, $Password)
    {
        $user = rtrim($DatabaseUser);
        $password = rtrim($Password);
        $host = rtrim($Host);
        $dbase = rtrim($DatabaseName);


        $con = mysqli_connect($host, $user, $password, $dbase);

        // Check connection
        if (mysqli_connect_errno()) {
            //echo "Failed to connect to MySQL: " . mysqli_connect_error();
            return false;
        } else {
            return true;
        }
    }
    //---Detect if remote database exists
    function detectIfRemoteDatabaseExists($DatabaseName, $DatabaseUser, $Host, $Password)
    {
        $user = rtrim($DatabaseUser);
        $password = rtrim($Password);
        $host = rtrim($Host);
        $dbase = rtrim($DatabaseName);


        $con = mysqli_connect($host, $user, $password, $dbase);

        // Check connection
        if (mysqli_connect_errno()) {
            //echo "Failed to connect to MySQL: " . mysqli_connect_error();
            return false;
        } else {
            return true;
        }
    }
    //---Get All Tables in local database
    function getAllTablesInLocalDatabase($DatabaseName, $DatabaseUser, $Host, $Password)
    {
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
            return $output;
        } else {
            echo $link->error;
        }
    }
    //---Get All Tables in remote database
    function getAllTablesInRemoteDatabase($DatabaseName, $DatabaseUser, $Host, $Password)
    {
        $user = rtrim($DatabaseUser);
        $password = rtrim($Password);
        $host = rtrim($Host);
        $dbase = rtrim($DatabaseName);


        $link = mysqli_connect($host, $user, $password, $dbase);
        $output = array();
        if ($stmt = $link->query("SHOW TABLES")) {
            //echo "No of records : " . $stmt->num_rows . "<br>";
            while ($row = $stmt->fetch_array()) {
                $output[] = $row[0];
            }
            return $output;
        } else {
            echo $link->error;
        }
    }
    //--
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
    //--Count all in table--
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
    //---Find rows occurrence in remote database
    function findOccurenceOftableDataInRemote($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
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
    //---Find rows occurrence in local database
    function findOccurenceOftableDataInLocal($DatabaseName, $DatabaseUser, $Host, $Password, $Tablename)
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
            echo 'Duplicate entry mehn '.$theError;
        }
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
