<script type="text/javascript">
	function getListSession(data) {
		$("#listChatLazada").html('');
		var html = '';
		for (var i = 0; i < data.length; i++) {
			html += '<div class="list-group-item list-group-item-action border-0" data-sessionId="'+data[i].session_id+'" data-image="'+data[i].head_url+'" data-name="'+data[i].title+'" data-lastMessageId="'+data[i].last_message_id+'" data-buyerId="'+data[i].buyer_id+'"><div class="badge bg-success float-right">'+data[i].unread_count+'</div><div class="d-flex align-items-start"><img src="'+data[i].head_url+'" class="rounded-circle mr-1" alt="Foto Profile" width="40" height="40"><div class="flex-grow-1 ml-3" style="padding-left: 20px;">'+data[i].title+'<div class="small"><span class="fas fa-circle chat-online"></span> '+data[i].summary+'</div></div></div></div>';
		}
		$("#listChatLazada").append(html);
		aktifKlik();
	};

	setInterval(function(){getChat();}, 1000 * 20);

	getChat();
	function getChat() {
	  $.ajax({
	    type: 'GET',
	    url: '<?php echo base_url()?>Lazada/getSessionChatLazada',
	    dataType: 'json',
	    success: function(data){
	      console.log(data.data.session_list);
	      getListSession(data.data.session_list);
	    }
	  })
	}

	var sessionId;
	var image;
	var name;
	var lastMessageId;
	var buyerId;

	function aktifKlik() {
		$(".list-group-item").on('click', function(){
			sessionId = $(this).attr("data-sessionId");
			image = $(this).attr("data-image");
			name= $(this).attr("data-name");
			lastMessageId = $(this).attr("data-lastMessageId");
			buyerId = $(this).attr("data-buyerId");
			ajaxIsiMessage(sessionId, image, name, lastMessageId);
			sendMessage();
		})
	}

	function ajaxIsiMessage(sessionId, image, name, lastMessageId) {
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Lazada/getMessageChatLazada',
			    dataType: 'json',
			    data: 'sessionId='+sessionId,
			    success: function(data){
			      console.log(data.data);
			      console.log(image, name);
			      getMessage(data.data.message_list, image, name, sessionId, lastMessageId);
			    }
			})
	}

	function ajaxReadSession(sessionId, lastMessageId) {
		$.ajax({
		    type: 'POST',
		    url: '<?php echo base_url()?>Lazada/readSessionChatLazada',
		    dataType: 'json',
		    data: 'sessionId='+sessionId+'&lastMessageId='+lastMessageId,
		    success: function(data){
		      console.log(data);
		      getChat();
		    }
		})
	}

	function getMessage(data, image, name, sessionId, lastMessageId) {
		ajaxReadSession(sessionId, lastMessageId);
		$("#isiMessage").html("");
		var html = '';
		var headerMessage = getHeaderMessage(image, name);
		for (var i = data.length - 1; i >= 0; i--) {
			var date = new Date(data[i].send_time).toString();
			// var date = new Date(data[i].send_time * 1000);
			var hours = date.substr(16, 2);
			var minutes = date.substr(19, 2);
			var formattedTime = hours + ':' + minutes;
			var template = getTemplateMessage(data[i]);
			var content = JSON.parse(data[i].content);
			if (data[i].from_account_type == 2) {
				html+='<div class="chat-message-right pb-4">'+
						'<div style="padding-left: 20px;">'+
						'<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="'+data[i].from_account_id+'" width="40" height="40">'+
						'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'+
						'</div>'+
						'<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">'+
						'<div class="font-weight-bold mb-1">You</div>'+
						template
						+'</div></div>'
			}else{
				html+='<div class="chat-message-left pb-4"><div style="padding-right: 20px;">'+
						'<img src="'+image+'" class="rounded-circle mr-1" alt="'+data[i].from_account_id+'" width="40" height="40">'+
						'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'+
						'</div><div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">'+
						'<div class="font-weight-bold mb-1">'+name+'</div>'+template+'	</div></div>'
			}
		}
		$("#headerMessage").html(headerMessage)
		$("#isiMessage").append(html);
	}

	function getHeaderMessage(gambar, nama) {
		return '<div class="d-flex align-items-center py-1">'+
				'<div class="position-relative">'+
				'<img src="'+gambar+'" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">'+
				'</div>'+
				'<div class="flex-grow-1 pl-3" style="padding: 10px">'+
				'<strong>'+nama+'</strong>'+
				// <div class="text-muted small"><em>Typing...</em></div>
				'</div>'+
				'<div>'+
				'<button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>'+
				'<button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></button>'+
				'<button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>'+
				'</div>'+
				'</div>'
	}

	function getTemplateMessage(data) {
		var content = JSON.parse(data.content);
		if (data.template_id == 1) {
			return content.txt
		} else if (data.template_id == 2) {
			return content.txt+'<a href='+content.recallContent+'>'+content.recallContent+'</a>'
		} else if (data.template_id == 3) {
			return '<img src="'+content.imgUrl+'" osskey="'+content.osskey+'" width="'+content.width+'" height="'+content.height+'">'
		}else if (data.template_id == 10006) {
			return '<a href="'+content.actionUrl+'" target="_blank">'+
			  '<div class="col-lg-4 mt-4 mb-3">'+
			    '<div class="card z-index-2" style="width: 500px">'+
			      '<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">'+
			        '<div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1" style="color: white; padding: 10px">'+
			          'Informasi Produk'+
			        '</div>'+
			      '</div>'+
			      '<div class="card-body" style="width: 490px">'+
			        '<table>'+
			          '<thead>'+
			            '<th rowspan="3"></th>'+
			            '<th></th>'+
			          '</thead>'+
			          '<tbody>'+
			            '<tr>'+
			              '<td style="padding-right: 15px"><img src="'+content.iconUrl+'" width="100px"></td>'+
			              '<td>'+
			                '<h6 class="mb-0 ">'+content.title+'</h6>'+
			                '<p class="text-sm ">'+content.price+'</p>'+
			                '<del>'+content.oldPrice+'</del>'+
			                '<hr class="dark horizontal">'+
			                '<div class="d-flex ">'+
			                  '<i class="material-icons text-sm my-auto me-1">discount</i>'+
			                  '<p class="mb-0 text-sm">'+content.discount+'</p>'+
			                '</div>'+
			              '</td>'+
			            '</tr>'+
			          '</tbody>'+
			        '</table>'+
			      '</div>'+
			    '</div>'+
			 '</div>'+
			'</a>'
		}else if (data.template_id == 10007) {
			return '<a href="'+content.actionUrl+'" target="_blank">'+
			  '<div class="col-lg-4 mt-4 mb-3">'+
			    '<div class="card z-index-2" style="width: 500px">'+
			      '<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">'+
			        '<div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1" style="color: white; padding: 10px">'+
			          content.orderId+
			        '</div>'+
			      '</div>'+
			      '<div class="card-body" style="width: 490px">'+
			        '<table>'+
			          '<thead>'+
			            '<th rowspan="3"></th>'+
			            '<th></th>'+
			          '</thead>'+
			          '<tbody>'+
			            '<tr>'+
			              '<td style="padding-right: 15px"><img src="'+content.iconUrl+'" width="100px"></td>'+
			              '<td>'+
			                '<h6 class="mb-0 ">'+content.productName+'</h6>'+
			                '<p class="text-sm ">'+content.status+'</p>'+
			                '<hr class="dark horizontal">'+
			                '<div class="d-flex ">'+
			                  '<i class="material-icons text-sm my-auto me-1">discount</i>'+
			                  '<p class="mb-0 text-sm">'+content.content+'</p>'+
			                '</div>'+
			              '</td>'+
			            '</tr>'+
			          '</tbody>'+
			        '</table>'+
			      '</div>'+
			    '</div>'+
			 '</div>'+
			'</a>'
		}
	}

	function sendMessage() {
		$('#btnSendMessage').on('click', function (){
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Lazada/sendMessageLazada',
			    dataType: 'json',
			    data: 'templateId=1&text='+$('#text').val()+'&sessionId='+sessionId,
			    success: function(data){
			    	$('#text').val('');
			    	ajaxIsiMessage(sessionId, image, name, lastMessageId);
			    }
			})
		})
	}

	function lazadaShowProduk(data) {
	  	console.log(data);
	  	var html = '';
	  	for (var i = data.length - 1; i >= 0; i--) {
		  	html += '<div class="col-xl-3 col-md-6 mb-xl-0 mb-4" style="padding-right: 200px; padding-top: 50px;">'+
	      			'<div class="card card-blog card-plain" style="width: 200px">'+
	        		'<div class="card-header p-0 mt-n4 mx-3">'+
	            	'<img src="'+data[i].images+'" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">'+
	        		'</div>'+
	        		'<div class="card-body p-3">'+
	          		'<p class="mb-0 text-sm"># '+data[i].item_id+'</p>'+
		              '<span class="text-sm" style="display: block;width: 180px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">'+data[i].attributes.name+'</span>'+
	          		'<p class="mb-4 text-sm">'+
	            		'Rp. '+data[i].skus[0].price+
	          		'</p>'+
	            	'<button type="button" class="btn btn-primary btn-sm kirimProduk" data-itemId="'+data[i].item_id+'">Kirim Produk</button>'+
	            	'<button type="button" class="btn btn-outline-primary btn-sm detailProduk" data-itemId="'+data[i].item_id+'">Detail</button>'+
	        		'</div>'+
	      			'</div>'+
	   				'</div>'
	  	}
	  	$("#rowProduk").append(html);
	  	aktifKirimProduk();
	}

	function aktifKirimProduk() {
	  	$('.kirimProduk').on('click', function(){
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Lazada/sendMessageLazada',
			    dataType: 'json',
			    data: 'templateId=10006&itemId='+$(this).attr('data-itemId')+'&sessionId='+sessionId,
			    success: function(data){
			    	ajaxIsiMessage(sessionId, image, name, lastMessageId);
			    }
			})
	  	})
	}
</script>