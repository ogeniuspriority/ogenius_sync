<script src="jquery/jquery-3.4.1.min.js">
</script>
<script>
    var init_test_passed = false;
    var appEnvSettings;
    var remoteDomainUrlForFiles = "";
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
                    type: 'GET', // http method
                    data: {
                        myData: 'This is my data.'
                    }, // data to submit
                    success: function(data, status, xhr) {
                        if (status == "success") {

                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        //$('p').append('Error' + errorMessage);
                        //alert('Error' + errorMessage);
                    }
                });
            } else {
                console.log("Config file contains errors!")
            }
        } else {
            console.log("Config Setup contains errors!")
        }

    }, 30000);
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