<?php
use ApplxeJwt\Jwtoken as jt;
use Rooms\Room as Rooms;
error_reporting(1);
session_start();
$url = getcwd();
$url = str_replace('message',"",$url);
// $newUri = $url+"decryptAuth.php";

$define = $url.'login/AuthO/define.php';
$token = $url.'login/AuthO/token.php';
include($define);
include($token);

if(!empty($_SESSION['token'])){

	$token = $_SESSION['token'];
	if(!empty($token)){
		$userData = jt::getDec($token,publicKey);
		// get userId and see rooms joned
		// print_r () ;
		$myId = $userData->token;
		echo $myId;
		// $rooms = new Rooms;
		// $rooms->getRooms($myId);

	}else{
		return false;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="assets/main.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="assets/main.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts" id="converPersonal">
							<!-- where to load rooms -->

							

							<!-- end of room load -->
						</ui>
					</div>
					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat">

					<!-- before load conversation and chat box here -->
					<div class="card clr">

					</div>
					<!-- End before load conversation and chat box here -->

					<!-- load conversation and chat box here -->
					<div class="card conversation" style="display:none;">
						<div class="card-header msg_head ">
							<div class="d-flex bd-highlight heighcustomer">
								
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i> View profile</li>
									<li><i class="fas fa-users"></i> Add to close friends</li>
									<li><i class="fas fa-plus"></i> Add to group</li>
									<li><i class="fas fa-ban"></i> Block</li>
								</ul>
							</div>
						</div>

						<div class="card-body msg_card_body conversations" style='height: 325px;' id="conversations">
													
						</div>

						<div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea name="" class="form-control type_msg submitMessages" placeholder="Type your message..."></textarea>
								<div class="input-group-append">
									<span class="input-group-text send_btn submitMessage"><i class="fas fa-location-arrow"></i></span>
								</div>
							</div>
							
						</div>
						<!-- End load conversation and chat box here -->
					</div>
				</div>
			</div>
			<div class="connection_status"></div>
		</div>
		
	</body>
</html>
<script>
	var conn = new WebSocket('ws://localhost:8080');
	conn.onopen = function(e) {
		$('.connection_status').html("Connection established!");
	};
	conn.onmessage = function(e) {
		console.log(e.data);

		
			innerMessages =`
						<div class="d-flex justify-content-start mb-4" data-message=>
							<div class="img_cont_msg">
								<img src="http://localhost/applxe/`+e.data.image+`png" class="rounded1-circle user_img_msg">
							</div>
							<div class="msg_cotainer">
								`+e.data.message+`
								<span class="msg_time">today</span>
							</div>
						</div>

					`;
			$('.conversations').append(innerMessages);	
			var objDiv = document.getElementById("conversations");
			var scrollheihgt = objDiv.clientHeight;
			$(objDiv).animate({"scrollTop":scrollheihgt},1000);	
			
	};

	

	$('.submitMessage').click(function(){

		var message = $('.submitMessages').val();
		var datas= $('.submitMessages').attr('data-roomname');
		var name= $('.submitMessages').attr('data-name');
		var image= $('.submitMessages').attr('data-img'); 

		console.log(image);
		message ={
			datas:datas,
			image:image,
			message:message
		}
		sendMessage(message);
		alert(<?php echo $myId;?>);
		var userId = <?php echo $myId;?>;

		var roomId = $('.submitMessages').attr('data-room');

		innerMessages =`
			<div class="d-flex justify-content-end mb-4">
				<div class="msg_cotainer_send">
					`+message.message+`
					<span class="msg_time">now</span>
				</div>
				<div class="img_cont_msg">
					<img src="http://localhost/applxe/`+message.image+`" class="rounded-circle user_img_msg">
				</div>
			</div>
		`;
		$('.conversations').append(innerMessages);
		// $.ajax({
		// 	url:'sendmessage.php',
		// 	data:{roomId:roomId,userId:userId,message:message},
		// 	dataType:'html',
		// 	success:function(data){
		// 		console.log(data);	
		// 	}
		// });
		var objDiv = document.getElementById("conversations");
		var scrollheihgt = objDiv.clientHeight;
		$(objDiv).animate({"scrollTop":scrollheihgt},1000);
		$('.submitMessages').val("");
	});
	// $('.submitMessages').keyup(function(){
	// 	// alert($(this).val());
	// 	onTyping('Typing now')
	// });
	function subscribe(channel) {
		conn.send(JSON.stringify({command: "subscribe", channel: channel}));
	}

	function sendMessage(msg) {

		conn.send(JSON.stringify({command: "message", message: msg}));
	}
	function onTyping(msg) {
		conn.send(JSON.stringify({command: "Typing", message: msg}));
	}
	// load all contacts
	$(document).ready(function(){
		var userId = <?php echo $myId;?>;
		$.ajax({
			url:'loadRooms.php',
			data:{userId:userId},
			dataType:'html',
			success:function(data){
				data = JSON.parse(data);
				data.forEach(element => {
					$('#converPersonal').append('<li class="converse"  style="cursor:pointer;"><div class="d-flex bd-highlight flowclick" onclick="openConversation(this) " data-roomname="'+element.roomID+'" data-img="http://localhost/applxe/public/'+element.avarter+'" data-name="'+element.username+'"><div class="img_cont"><img src="http://localhost/applxe/public/'+element.avarter+'" class="rounded-circle user_img"><span class="online_icon"></span></div><div class="user_info"<span>'+element.username+'</span><p>'+element.username+' is online</p></div></div></li>');
				});
				
			}
		});
	});
	// load all contacts
	function openConversation(action){
		var datas= $(action).attr('data-roomname');
		var name= $(action).attr('data-name');
		var image= $(action).attr('data-img'); 

		$('.submitMessages').attr('data-room',datas);
		$('.submitMessages').attr('data-img',datas);

		$valElement = `
		<div class="img_cont">

			<img src="`+image+`" class="imageAvarter rounded-circle user_img">
			<span class="online_icon"></span>

		</div>
		<div class="user_info">
			<span class="chatWith">`+name+`</span>
			<p class="typing">Active 2mins Ago</p>
		</div>
		<div class="video_cam">
			<span><i class="fas fa-video"></i></span>
			<span><i class="fas fa-phone"></i></span>
		</div>
		`;
		$('.heighcustomer').html($valElement);
		var userId = <?php echo $myId;?>;

		// var imageAvarter = $('.imageAvarter').html(name);
		$('.clr').css({'display':'none'});
		$('.conversation').css({'display':'block'});
		// open channel to send message
		subscribe(datas);
		// end  of open message channel
		$.ajax({
			url:'loadMessages.php',
			data:{roomId:datas},
			dataType:'html',
			success:function(data){
				data = JSON.parse(data);
				var innerMessages;
				if(data ==""){
					$('.conversations').html('You have no active chat');
				}else{
					data.forEach(Element=>{
					
					if(Element.userID != userId){	
						innerMessages +=`
						<div class="d-flex justify-content-start mb-4" data-message=`+Element.message_id+`>
							<div class="img_cont_msg">
								<img src="http://localhost/applxe/public/`+Element.avarter+`" class="rounded-circle user_img_msg">
							</div>
							<div class="msg_cotainer">
								`+Element.message+`
								<span class="msg_time">`+Element.date_sent+`</span>
							</div>
						</div>

					`;
					}else{
						innerMessages +=`
							<div class="d-flex justify-content-end mb-4">
								<div class="msg_cotainer_send">
									`+Element.message+`
									<span class="msg_time">`+Element.date_sent+`</span>
								</div>
								<div class="img_cont_msg">
									<img src="http://localhost/applxe/public/`+Element.avarter+`" class="rounded-circle user_img_msg">
								</div>
							</div>
						`;
					}
					$('.conversations').html(innerMessages);

				});
				}
				
				
			}
		});
		var objDiv = document.getElementById("conversations");
		var scrollheihgt = objDiv.clientHeight;
		$(objDiv).animate({"scrollTop":scrollheihgt},2000);
	}
	
</script>
<?php
}else{
	echo "please click the <a href='http://localhost/applxe/Api/message/login.php'>Login</a>";
}
?>