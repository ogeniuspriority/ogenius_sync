<script src="jquery/jquery-3.4.1.min.js">
</script>
<script>
    var init_test_passed = false;
    var appEnvSettings;
    var remoteDomainUrlForFiles = "http://localhost/ogenius_sync/";
    var appRemoteTables;
    var appLocalTables;
    $(document).ready(function() {
        $.ajax('init/init_sync.php', {
            type: 'GET', // http method
            data: {
                myData: 'This is my data.'
            }, // data to submit
            success: function(data, status, xhr) {
                //$('p').append('status: ' + status + ', data: ' + data);
                var resJSON = JSON.parse(data);
                appEnvSettings = resJSON;
                //alert('status: ' + status + ', data: ' + resJSON.DATABASE_LOCAL_DB_USERNAME.trim());
                //console.log('status: ' + status + ', data: ' + resJSON);
                if (status == "success") {
                    document.getElementById("DATABASE_LOCAL_DB_NAME").value = resJSON.DATABASE_LOCAL_DB_NAME.trim();
                    document.getElementById("DATABASE_LOCAL_DB_HOST").value = resJSON.DATABASE_LOCAL_DB_HOST.trim();
                    document.getElementById("DATABASE_LOCAL_DB_URL").value = resJSON.DATABASE_LOCAL_DB_URL.trim();
                    document.getElementById("DATABASE_LOCAL_DB_USERNAME").value = resJSON.DATABASE_LOCAL_DB_USERNAME.trim();
                    document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value = resJSON.DATABASE_LOCAL_DB_PASSWORD.trim();
                    document.getElementById("DATABASE_REMOTE_DB_NAME").value = resJSON.DATABASE_REMOTE_DB_NAME.trim();
                    document.getElementById("DATABASE_REMOTE_DB_HOST").value = resJSON.DATABASE_REMOTE_DB_HOST.trim();
                    document.getElementById("DATABASE_REMOTE_DB_URL").value = resJSON.DATABASE_REMOTE_DB_URL.trim();
                    document.getElementById("DATABASE_REMOTE_DB_USERNAME").value = resJSON.DATABASE_REMOTE_DB_USERNAME.trim();
                    document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value = resJSON.DATABASE_REMOTE_DB_PASSWORD.trim();
                    document.getElementById("DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE").value = resJSON.DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE.trim();
                    //--------------------------
                    init_test_passed = true;
                    //alert(JSON.stringify(appEnvSettings));

                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                //$('p').append('Error' + errorMessage);
                //alert('Error' + errorMessage);
            }
        });
    });
    //-----Lifecycle Timer---------------------
    var mainTimer = window.setInterval(function() {
        if (init_test_passed) {
            //---Detect if config file is legit--
            var count = Object.keys(appEnvSettings).length;
            if (parseInt(count) == 11) {

                $.ajax('local_codebase/detect_if_local_database_exists.php', {
                    type: 'POST', // http method
                    data: {
                        DatabaseUser: document.getElementById("DATABASE_LOCAL_DB_USERNAME").value,
                        Password: document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value,
                        Host: document.getElementById("DATABASE_LOCAL_DB_URL").value,
                        DatabaseName: document.getElementById("DATABASE_LOCAL_DB_NAME").value
                    }, // data to submit
                    success: function(data, status, xhr) {
                        if (status == "success") {

                            if (data == "1") {
                                console.log("Local database exists!!!");
                                ///---Detect remote database--
                                $.ajax(remoteDomainUrlForFiles + 'remote_codebase/detect_if_remote_database_exists.php', {
                                    type: 'POST', // http method
                                    data: {
                                        DatabaseUser: document.getElementById("DATABASE_REMOTE_DB_USERNAME").value,
                                        Password: document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value,
                                        Host: document.getElementById("DATABASE_REMOTE_DB_URL").value,
                                        DatabaseName: document.getElementById("DATABASE_REMOTE_DB_NAME").value,
                                        remoteDomainUrlForFiles:remoteDomainUrlForFiles
                                    }, // data to submit
                                    success: function(data, status, xhr) {
                                        if (status == "success") {

                                            if (data == "1") {
                                                console.log("Remote database exists!!!");
                                                ///---See tables in local database--
                                                $.ajax('local_codebase/see_tables_in_local_database.php', {
                                                    type: 'POST', // http method
                                                    data: {
                                                        DatabaseUser: document.getElementById("DATABASE_LOCAL_DB_USERNAME").value,
                                                        Password: document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value,
                                                        Host: document.getElementById("DATABASE_LOCAL_DB_URL").value,
                                                        DatabaseName: document.getElementById("DATABASE_LOCAL_DB_NAME").value
                                                    }, // data to submit
                                                    success: function(data, status, xhr) {
                                                        if (status == "success") {

                                                            if (!data.includes("error")) {
                                                                console.log("Tables in local found!");
                                                                ///---See tables in remote database--
                                                                $.ajax(remoteDomainUrlForFiles + 'remote_codebase/see_tables_in_remote_database.php', {
                                                                    type: 'POST', // http method
                                                                    data: {
                                                                        DatabaseUser: document.getElementById("DATABASE_REMOTE_DB_USERNAME").value,
                                                                        Password: document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value,
                                                                        Host: document.getElementById("DATABASE_REMOTE_DB_URL").value,
                                                                        DatabaseName: document.getElementById("DATABASE_REMOTE_DB_NAME").value,
                                                                        remoteDomainUrlForFiles:remoteDomainUrlForFiles
                                                                    }, // data to submit
                                                                    success: function(data, status, xhr) {
                                                                        if (status == "success") {

                                                                            if (!data.includes("error")) {
                                                                                console.log("Tables in remote found!");
                                                                                ///---Get tables in local database--
                                                                                $.ajax('local_codebase/see_tables_in_local_database.php', {
                                                                                    type: 'POST', // http method
                                                                                    data: {
                                                                                        DatabaseUser: document.getElementById("DATABASE_LOCAL_DB_USERNAME").value,
                                                                                        Password: document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value,
                                                                                        Host: document.getElementById("DATABASE_LOCAL_DB_URL").value,
                                                                                        DatabaseName: document.getElementById("DATABASE_LOCAL_DB_NAME").value
                                                                                    }, // data to submit
                                                                                    success: function(dataLocalTables, status, xhr) {
                                                                                        if (status == "success") {

                                                                                            if (!dataLocalTables.includes("error")) {
                                                                                                console.log("Tables in remote collected!");
                                                                                                ///---Get tables in local database--
                                                                                                var resJSON = JSON.parse(dataLocalTables);
                                                                                                console.log(dataLocalTables);
                                                                                                appLocalTables = resJSON;
                                                                                                //---Get all tables in remote database
                                                                                                $.ajax(remoteDomainUrlForFiles + 'remote_codebase/see_tables_in_remote_database.php', {
                                                                                                    type: 'POST', // http method
                                                                                                    data: {
                                                                                                        DatabaseUser: document.getElementById("DATABASE_REMOTE_DB_USERNAME").value,
                                                                                                        Password: document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value,
                                                                                                        Host: document.getElementById("DATABASE_REMOTE_DB_URL").value,
                                                                                                        DatabaseName: document.getElementById("DATABASE_REMOTE_DB_NAME").value,
                                                                                                        remoteDomainUrlForFiles:remoteDomainUrlForFiles
                                                                                                    }, // data to submit
                                                                                                    success: function(dataRemoteTables, status, xhr) {
                                                                                                        if (status == "success") {

                                                                                                            if (!dataRemoteTables.includes("error")) {
                                                                                                                console.log("Tables in remote collected!");
                                                                                                                ///---Get tables in remote database--
                                                                                                                var resJSON = JSON.parse(dataRemoteTables);
                                                                                                                console.log(dataRemoteTables);
                                                                                                                appRemoteTables = resJSON;
                                                                                                                //----Compare number of tables on all ends--
                                                                                                                var countLocalTables = Object.keys(appLocalTables).length;
                                                                                                                var countRemoteTables = Object.keys(appRemoteTables).length;
                                                                                                                if (parseInt(countLocalTables) == parseInt(countRemoteTables)) {
                                                                                                                    console.log("Tables in both remote and local database match!!" + "---" + countRemoteTables + " tables");
                                                                                                                    console.log("Local to remote database tables comparisons")
                                                                                                                    //------------Get Local table structure----------
                                                                                                                    $.ajax('local_codebase/get_local_tables_each_one_structure.php', {
                                                                                                                        type: 'POST', // http method
                                                                                                                        data: {
                                                                                                                            tablesInLocalDB: JSON.stringify(appLocalTables),
                                                                                                                            tablesInRemoteDB: JSON.stringify(appRemoteTables),
                                                                                                                            DatabaseUser: document.getElementById("DATABASE_LOCAL_DB_USERNAME").value,
                                                                                                                            Password: document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value,
                                                                                                                            Host: document.getElementById("DATABASE_LOCAL_DB_URL").value,
                                                                                                                            DatabaseName: document.getElementById("DATABASE_LOCAL_DB_NAME").value,
                                                                                                                            DatabaseUser_REMOTE: document.getElementById("DATABASE_REMOTE_DB_USERNAME").value,
                                                                                                                            Password_REMOTE: document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value,
                                                                                                                            Host_REMOTE: document.getElementById("DATABASE_REMOTE_DB_URL").value,
                                                                                                                            DatabaseName_REMOTE: document.getElementById("DATABASE_REMOTE_DB_NAME").value,
                                                                                                                            remoteDomainUrlForFiles:remoteDomainUrlForFiles
                                                                                                                        }, // data to submit
                                                                                                                        success: function(dataCompareTables, status, xhr) {
                                                                                                                            if (status == "success") {

                                                                                                                                if (!dataCompareTables.includes("error")) {
                                                                                                                                    console.log("Tables comparison success!" + dataCompareTables);
                                                                                                                                    //--
                                                                                                                                    $.ajax('local_codebase/sync_from_local_to_remote.php', {
                                                                                                                                        type: 'POST', // http method
                                                                                                                                        data: {
                                                                                                                                            tablesInLocalDB: JSON.stringify(appLocalTables),
                                                                                                                                            tablesInRemoteDB: JSON.stringify(appRemoteTables),
                                                                                                                                            DatabaseUser: document.getElementById("DATABASE_LOCAL_DB_USERNAME").value,
                                                                                                                                            Password: document.getElementById("DATABASE_LOCAL_DB_PASSWORD").value,
                                                                                                                                            Host: document.getElementById("DATABASE_LOCAL_DB_URL").value,
                                                                                                                                            DatabaseName: document.getElementById("DATABASE_LOCAL_DB_NAME").value,
                                                                                                                                            DatabaseUser_REMOTE: document.getElementById("DATABASE_REMOTE_DB_USERNAME").value,
                                                                                                                                            Password_REMOTE: document.getElementById("DATABASE_REMOTE_DB_PASSWORD").value,
                                                                                                                                            Host_REMOTE: document.getElementById("DATABASE_REMOTE_DB_URL").value,
                                                                                                                                            DatabaseName_REMOTE: document.getElementById("DATABASE_REMOTE_DB_NAME").value,
                                                                                                                                            DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE: document.getElementById("DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE").value,
                                                                                                                                            remoteDomainUrlForFiles:remoteDomainUrlForFiles
                                                                                                                                        }, // data to submit
                                                                                                                                        success: function(dataCompareTables, status, xhr) {
                                                                                                                                            if (status == "success") {

                                                                                                                                                if (!dataCompareTables.includes("error")) {
                                                                                                                                                    console.log("Tables comparison success!" + dataCompareTables);
                                                                                                                                                    //--

                                                                                                                                                } else {
                                                                                                                                                    console.log(dataCompareTables);
                                                                                                                                                }

                                                                                                                                            }
                                                                                                                                        },
                                                                                                                                        error: function(jqXhr, textStatus, errorMessage) {
                                                                                                                                            //$('p').append('Error' + errorMessage);
                                                                                                                                            //alert('Error' + errorMessage);
                                                                                                                                            console.log("Tables comparison failure!");
                                                                                                                                        }
                                                                                                                                    });


                                                                                                                                } else {
                                                                                                                                    console.log(dataCompareTables);
                                                                                                                                }

                                                                                                                            }
                                                                                                                        },
                                                                                                                        error: function(jqXhr, textStatus, errorMessage) {
                                                                                                                            //$('p').append('Error' + errorMessage);
                                                                                                                            //alert('Error' + errorMessage);
                                                                                                                            console.log("Tables comparison failure!");
                                                                                                                        }
                                                                                                                    });
                                                                                                                    //----------------

                                                                                                                } else {
                                                                                                                    console.log("Tables in remote and local do not match!!")
                                                                                                                }
                                                                                                            } else {
                                                                                                                console.log(dataRemoteTables);
                                                                                                            }

                                                                                                        }
                                                                                                    },
                                                                                                    error: function(jqXhr, textStatus, errorMessage) {
                                                                                                        //$('p').append('Error' + errorMessage);
                                                                                                        //alert('Error' + errorMessage);
                                                                                                        console.log("Table search in remote failure!!");
                                                                                                    }
                                                                                                });
                                                                                            } else {
                                                                                                console.log(dataLocalTables);
                                                                                            }

                                                                                        }
                                                                                    },
                                                                                    error: function(jqXhr, textStatus, errorMessage) {
                                                                                        //$('p').append('Error' + errorMessage);
                                                                                        //alert('Error' + errorMessage);
                                                                                        console.log("Table search in local failure!!");
                                                                                    }
                                                                                });
                                                                            } else {
                                                                                console.log(data);
                                                                            }

                                                                        }
                                                                    },
                                                                    error: function(jqXhr, textStatus, errorMessage) {
                                                                        //$('p').append('Error' + errorMessage);
                                                                        //alert('Error' + errorMessage);
                                                                        console.log("Table search in remote failure!!");
                                                                    }
                                                                });
                                                            } else {
                                                                console.log(data);
                                                            }

                                                        }
                                                    },
                                                    error: function(jqXhr, textStatus, errorMessage) {
                                                        //$('p').append('Error' + errorMessage);
                                                        //alert('Error' + errorMessage);
                                                        console.log("Table search in local failure!!");
                                                    }
                                                });
                                            } else {
                                                console.log(data);
                                            }

                                        }
                                    },
                                    error: function(jqXhr, textStatus, errorMessage) {
                                        //$('p').append('Error' + errorMessage);
                                        //alert('Error' + errorMessage);
                                        console.log("remote database does not exists!!");
                                    }
                                });
                            } else {
                                console.log(data);
                            }

                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        //$('p').append('Error' + errorMessage);
                        //alert('Error' + errorMessage);
                        console.log("Local database does not exists!!");
                    }
                });
            } else {
                console.log("Config file contains errors!")
            }
        } else {
            console.log("Config Setup contains errors!")
        }

    }, 5000);
    //-----------------



    //------------
    /*$.ajax('/jquery/submitData', {
        type: 'POST', // http method
        data: {
            myData: 'This is my data.'
        }, // data to submit
        success: function(data, status, xhr) {
            $('p').append('status: ' + status + ', data: ' + data);
        },
        error: function(jqXhr, textStatus, errorMessage) {
            $('p').append('Error' + errorMessage);
        }
    });*/
</script>
<input type="hidden" id="DATABASE_LOCAL_DB_NAME" />
<input type="hidden" id="DATABASE_LOCAL_DB_HOST" />
<input type="hidden" id="DATABASE_LOCAL_DB_URL" />
<input type="hidden" id="DATABASE_LOCAL_DB_USERNAME" />
<input type="hidden" id="DATABASE_LOCAL_DB_PASSWORD" />
<input type="hidden" id="DATABASE_REMOTE_DB_NAME" />
<input type="hidden" id="DATABASE_REMOTE_DB_HOST" />
<input type="hidden" id="DATABASE_REMOTE_DB_URL" />
<input type="hidden" id="DATABASE_REMOTE_DB_USERNAME" />
<input type="hidden" id="DATABASE_REMOTE_DB_PASSWORD" />
<input type="hidden" id="DATABASE_SYNC_ROW_FREQUENCY_PER_TABLE" />