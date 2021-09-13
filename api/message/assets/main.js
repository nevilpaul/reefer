$(document).ready(function(){

    $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });

});

$(document).ready(function(){
    $('#loginBtn').click(function(){
        username = $('#user').val();
        password = $('#pass').val();
        uri = "http://localhost/applxe/";
        $.ajax({
            
            url: uri+'Api/login/index.php',
            method: "GET",
            data: {
                username: username,
                password: password
            },
            dataType: "html",
            success: function (data) {
              data = JSON.parse(data);
              console.log(data); 
              if(data['accountType'] !=""){
                window.location.href = uri+"Api/message/message.php"; 
              }  
              
            }
        });
        // alert();
    });
});