var currentSeller;
var transferSeller;

function populateTransferCombo() {
	$('#transfer-to-combo').combobox('reload','sellers/get_sellers.php');
	$('#transfer-to-combo').combobox({onLoadSuccess: function() {
			var cc = $('#sellers-combo');
			var state = cc.data('combobox');
			var opts = state.options;
			var value = cc.combobox('getValue');
			var el = opts.finder.getEl(cc[0], value);
			var index = el.attr('id').substr(state.itemIdPrefix.length+1);
			$('#transfer-to-combo').combobox('deleteItem', index);
		}
	});
}

function selectSeller(seller) {
	currentSeller = seller;

	$('#items').empty();
	$('#day_1').empty();
	$('#day_2').empty();
	$('#day_3').empty();
	$('#day_4').empty();
	$('#day_5').empty();

	populateTransferCombo();
	populateSchedule();
}

function selectTransferSeller(seller) {
	transferSeller = seller;
}

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
			var self = this;

			if($(source).hasClass('assigned')) {
				var schedule_entry_id = $(source).data("schedule_entry_id");
				$.ajax({
					url: window.apiBaseUrl + "/v1/schedule_entries/" + schedule_entry_id,
					method: 'PUT',
					data: {
						seller_id: currentSeller.id,
						client_id: client_id,
						day_of_week: day_of_week
					},
					headers: {
						authorization: Cookies.get("tmtoken")
					}
				}).then(function() {
					$(self).append(source);
				});
			} 
			else {
				$.ajax({
					url: window.apiBaseUrl + "/v1/schedule_entries",
					method: 'POST',
					data: {
						seller_id: currentSeller.id,
						client_id: client_id,
						day_of_week: day_of_week
					},
					headers: {
						authorization: Cookies.get("tmtoken")
					}
				}).then(function(response) {
					// guardar el id del schedule entry
					var c = $(source).clone().addClass('assigned');
					$(source).remove();
					$(self).append(c);
					c.draggable({
						revert:true
					});

					$(c).data("schedule_entry_id", response.id);
				});
			}
		}
	});
	$('.left').droppable({
		accept:'.assigned',
		onDrop:function(e,source) {
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

function populateSchedule() {
	$.post('clients/get_unassigned_clients.php',{},function(clients) {
		//console.log(clients);
		$.each(clients, function(i, client) {
            $('#items').append(
            	$('<div>', { "class" : "item", "id":client.id }).text(client.name+" "+client.lastname)
            );
        });

        setItemsDraggable();
	},'json');

	$.post('schedule/get_seller_schedule.php',{seller_id:currentSeller.id},function(entries) {
		//console.log(entries);
		$.each(entries, function(i, entry) {
    		$.post('clients/get_client.php',{id:entry.client_id},function(client) {
    						var el = $('<div>', { "class":"item assigned", "id":client.id });
    						el.data("schedule_entry_id", entry.id);

                $('#day_'+entry.day_of_week).append(
									el.text(client.name+" "+client.lastname)
                );
                setItemsDraggable();
			},'json');
        });
	},'json');
}

function transferClients() {
	if(transferSeller) {
		$.messager.confirm('Confirmación','¿Confirma la transferencia de todos los clientes de '+currentSeller.email+' a '+transferSeller.email+'?',function(r) {
			
			$.post('schedule/get_seller_schedule.php',{seller_id:currentSeller.id},function(entries) {
				$.each(entries, function(i, entry) {
					$.post('schedule/delete_schedule_entry.php',{client_id: entry.client_id}, function(result) {
						$.ajax({
							url: window.apiBaseUrl + "/v1/schedule_entries",
							method: 'POST',
							data: {
								seller_id: transferSeller.id,
								client_id: entry.client_id,
								day_of_week: entry.day_of_week
							},
							headers: {
								authorization: Cookies.get("tmtoken")
							}
						}).success(function(response) {
							// voy quitando de la tabla los transferidos
							$('div.assigned#'+entry.client_id).remove();
						});
					},'json');
		        });
			},'json');
		});
	}
}