<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>chat</title>
</head>
<body>
    <div class="container-flid">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <form action="">
                    <br>
                    <br>
                    <div class="form-group">
                        <!-- <label for="email">E:</label> -->
                        <input type="text" class="form-control" placeholder="Enter Room Name" id="room">
                    </div>
                    <button type="button" class="btn btn-primary submit col-sm-12" >Submit</button>
                </form>

                <div class="connection_status"></div>
                <div class="message"></div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <form action="">
                    <br>
                    <br>
                    <div class="form-group">
                        <!-- <label for="email">E:</label> -->
                        <input type="text" class="form-control" placeholder="Username" id="user">
                        <input type="text" class="form-control" placeholder="Enter your message Name" id="message">
                    </div>
                    <button type="button" class="btn btn-primary submitMessage col-sm-12" >Submit</button>
                </form>
                
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
<script>
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    $('.connection_status').html("Connection established!");
    
};

conn.onmessage = function(e) {
    console.log(e.data);
    // $('.message').append(e.data);
};
function room(channel) {
    var userId = Math.floor( Math.random()*100000);
    conn.send(JSON.stringify({command: "subscribe", channel: channel,userId:userId}));
}

$('.submit').click(function(){

    var room = $('#room').val();
    subscribe(room);
    

    // var userId = 2;
    // $.ajax({
    //     url:'addroom.php',
    //     data:{roomName:room,userId:userId},
    //     dataType:'html',
    //     success:function(data){
    //         console.log(data);
    //     }
    // });
});

$('.submitMessage').click(function(){

    var message = $('#message').val();
    sendMessage(message)
});
function subscribe(channel) {
    conn.send(JSON.stringify({command: "subscribe", channel: channel}));
}

function sendMessage(msg) {
    conn.send(JSON.stringify({command: "message", message: msg}));
}
</script>   
</body>
</html>