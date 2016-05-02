var currentSeller;

function setItemsDraggable() {
	$('.item').draggable({
		revert: true
	});
	$('.right td.drop').droppable({
		onDragEnter:function(){
			$(this).addClass('over');
		},
		onDragLeave:function(){
			$(this).removeClass('over');
		},
		onDrop:function(e, source){
			var client_id = $(source)[0].id;
			var day_of_week = $(this)[0].id.substr($(this)[0].id.length-1, 1);

			$(this).removeClass('over');
			if ($(source).hasClass('assigned')){
				$(this).append(source);

				$.post('schedule/edit_schedule_entry.php',{seller_id: currentSeller.id, client_id: client_id, day_of_week: day_of_week}, function(result) {},'json');
			} 
			else {
				var c = $(source).clone().addClass('assigned');
				$(source).remove();
				$(this).append(c);
				c.draggable({
					revert:true
				});

				$.post('schedule/create_schedule_entry.php',{seller_id:currentSeller.id, client_id: client_id, day_of_week: day_of_week}, function(result) {},'json');
			}
		}
	});
	$('.left').droppable({
		accept:'.assigned',
		onDrop:function(e,source){
			var c = $(source).clone().removeClass('assigned');
			$(source).remove();
			$('#items').append(c);
			c.draggable({
				revert:true
			});

			var client_id = $(source)[0].id;
			$.post('schedule/delete_schedule_entry.php',{client_id: client_id}, function(result) {},'json');
		}
	});
}

function populateSchedule(seller) {
	currentSeller = seller;

	$('#items').empty();
	$('#day_1').empty();
	$('#day_2').empty();
	$('#day_3').empty();
	$('#day_4').empty();
	$('#day_5').empty();

	$.post('clients/get_unassigned_clients.php',{},function(clients) {
		//console.log(clients);
		$.each(clients, function(i, client) {
            $('#items').append(
            	$('<div>', { "class" : "item", "id":client.id }).text(client.name+" "+client.lastname)
            );
        });

        setItemsDraggable();
	},'json');

	$.post('schedule/get_seller_schedule.php',{seller_id:seller.id},function(entries) {
		//console.log(entries);

		$.each(entries, function(i, entry) {
    		$.post('clients/get_client.php',{id:entry.client_id},function(client) {
                $('#day_'+entry.day_of_week).append(
                	$('<div>', { "class":"item assigned", "id":client.id }).text(client.name+" "+client.lastname)
                );
                setItemsDraggable();
			},'json');
        });
	},'json');
}