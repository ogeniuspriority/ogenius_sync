<script src="jquery/jquery-3.4.1.min.js">
</script>
<script>
    $(document).ready(function() {
        $.ajax('https://google.com', {
            type: 'GET', // http method
            data: {
                myData: 'This is my data.'
            }, // data to submit
            success: function(data, status, xhr) {
                //$('p').append('status: ' + status + ', data: ' + data);
                alert('status: ' + status + ', data: ' + data);
            },
            error: function(jqXhr, textStatus, errorMessage) {
                //$('p').append('Error' + errorMessage);
                alert('Error' + errorMessage);
            }
        });
    });
    //--------------------------
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