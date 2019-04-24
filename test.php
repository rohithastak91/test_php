<html>
<head>
	<title>Home Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
  .waiting {
    position: fixed;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.2);
    top: 0; 
}
.result{
      display: block;
    min-height: 200px;
}
        </style>
</head>
<body>
    <div class="waiting" style="display:none"></div>
    <span>Enter URL:</span>

        <input type="text" id="url_id" name="url">

        <button id="smbt" value="Submit">Generate code</button> 
        
        <span class="result"> </span>

        <div class="boards">
            <h5>Most visited URLs : </h5>
            <div class="listing">
                
            </div>
        </div>
</body>
</html>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script>
     
    $(document).ready(function(){
        
        var pageURL = $(location).attr("href");
            if(pageURL != 'http://172.10.1.5:8097/Inchora/cron/test.php'){
                $.ajax({
                    type:'POST',  
                    url: 'http://172.10.1.5:8097/Inchora/cron/function.php',
                    data: {'pageURL': pageURL},
                      beforeSend: function () {
                            $(".waiting").show();

                        },
                    success: function (data1) {
                         $(".waiting").hide();
                       window.location.replace(data1);
                    },
                    error: function (xhr, status, error) {
                        // executed if something went wrong during call
                        if (xhr.status > 0) alert('got error: ' + status); // status 0 - when load is interrupted
                    }
            }); 
            }else{
                 $.ajax({
                        type:'POST',  
                        url: 'http://172.10.1.5:8097/Inchora/cron/function.php',
                        data: {'flag': '1'},
                          
                        success: function (data1) {
                              $('.listing').html('');
                              var data1 = JSON.parse(data1);
                              
                            $.each(data1, function (key, value) { 
                                $('.listing').append('<p>'+value.url+'</p>');
                             });  
                       
                        },
                        error: function (xhr, status, error) {
                            // executed if something went wrong during call
                            if (xhr.status > 0) alert('got error: ' + status); // status 0 - when load is interrupted
                        }
                 });
            }
            
              
        
        
        
            $('#smbt').click(function(){
                var url = $('#url_id').val();
                  $.ajax({
                    type:'POST',  
                    url: 'http://172.10.1.5:8097/Inchora/cron/function.php',
                    data: {'url': url},
                    success: function (data) {
                        // this is executed when ajax call finished well
                        $('.result').html('');
                       $('.result').append('<h5>'+data+'</h5>');
                    },
                    error: function (xhr, status, error) {
                        // executed if something went wrong during call
                        if (xhr.status > 0) alert('got error: ' + status); // status 0 - when load is interrupted
                    }
                });
            });
     
    })
</script>