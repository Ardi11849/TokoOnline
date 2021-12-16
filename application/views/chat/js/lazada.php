<script type="text/javascript">
	$(document).ready( function () {
		function getListSession(data) {
			var html = '';
			for (var i = 0; i < data.length; i++) {
				html += '<div class="list-group-item list-group-item-action border-0" data-sessionId="'+data[i].session_id+'" data-image="'+data[i].head_url+'" data-name="'+data[i].title+'" data-lastMessageId="'+data[i].last_message_id+'"><div class="badge bg-success float-right">'+data[i].unread_count+'</div><div class="d-flex align-items-start"><img src="'+data[i].head_url+'" class="rounded-circle mr-1" alt="Foto Profile" width="40" height="40"><div class="flex-grow-1 ml-3" style="padding-left: 20px;">'+data[i].title+'<div class="small"><span class="fas fa-circle chat-online"></span> '+data[i].summary+'</div></div></div></div>';
			}
			$("#listChatLazada").append(html);
			aktifKlik();
		};

		getChat();
		function getChat() {
		  $.ajax({
		    type: 'GET',
		    url: '<?php echo base_url()?>Chat/getSessionChatLazada',
		    dataType: 'json',
		    success: function(data){
		      console.log(data.data.session_list);
		      getListSession(data.data.session_list);
		    }
		  })
		}

		function aktifKlik() {
			$(".list-group-item").on('click', function(){
				console.log($(this).attr("data-sessionId"));
				var sessionId = $(this).attr("data-sessionId");
				var image = $(this).attr("data-image");
				var name= $(this).attr("data-name");
				var lasMessageId = $(this).attr("data-lastMessageId");
				$.ajax({
				    type: 'POST',
				    url: '<?php echo base_url()?>Chat/getMessageChatLazada',
				    dataType: 'json',
				    data: 'sessionId='+sessionId,
				    success: function(data){
				      console.log(data.data.message_list);
				      console.log(image, name);
				      getMessage(data.data.message_list, image, name, sessionId, lasMessageId)
				    }
				})
			})
		}

		function ajaxReadSession(sessionId, lasMessageId) {
				$.ajax({
				    type: 'POST',
				    url: '<?php echo base_url()?>Chat/readSessionChatLazada',
				    dataType: 'json',
				    data: 'sessionId='+sessionId+'&lasMessageId='+lasMessageId,
				    success: function(data){
				      console.log(data);
				    }
				})
		}

		function getMessage(data, image, name, sessionId, lasMessageId) {
			ajaxReadSession(sessionId, lasMessageId);
			$("#isiMessage").html("");
			console.log(image, name)
			var html = '';
			for (var i = data.length - 1; i >= 0; i--) {
				var date = new Date(data[i].send_time * 1000);
				var hours = date.getHours();
				var minutes = "0" + date.getMinutes();
				var formattedTime = hours + ':' + minutes.substr(-2);
				if (data[i].from_account_type == 2) {
					html+='<div class="chat-message-right pb-4">	<div>		<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="'+data[i].from_account_id+'" width="40" height="40">		<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>	</div>	<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">		<div class="font-weight-bold mb-1">You</div>'+data[i].content+'</div></div>'
				}else{
					html+='<div class="chat-message-left pb-4"><div style="padding-right: 20px;"><img src="'+image+'" class="rounded-circle mr-1" alt="'+data[i].from_account_id+'" width="40" height="40"><div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div></div><div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">		<div class="font-weight-bold mb-1">'+name+'</div>'+data[i].content+'	</div></div>'
				}
			}
			$("#isiMessage").append(html);
		}
	} );
</script>