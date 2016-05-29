var url;
var method;

$('#fm input[name=change_password]').on('change', function() {
	var disabled = !($('#fm input[name=change_password]').prop('checked'));
	$('#fm input[name=password]').val("");
	$('#fm input[name=password_confirmation]').val("");
	$('#fm input[name=password]').prop('disabled', disabled);
	$('#fm input[name=password_confirmation]').prop('disabled', disabled);
});

function newSeller() {
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Vendedor');
	$('#fm').form('clear');
	setImage("avatarImg", "");

	$('#fm input[name=password]').val("");
	$('#fm input[name=password_confirmation]').val("");
	$('#fm input[name=password]').prop('disabled', true);
	$('#fm input[name=password_confirmation]').prop('disabled', true);
	$('#fm input[name=change_password]').prop('checked', false);

	url = window.apiBaseUrl + "/v1/sellers";
	method = 'POST';
}

function editSeller() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Editar Vendedor');
		$('#fm').form('load',row);
		setImage("avatarImg", row.avatar);

		$('#fm input[name=password]').prop('disabled', true);
		$('#fm input[name=password_confirmation]').prop('disabled', true);
		$('#fm input[name=change_password]').prop('checked', false);

		url = window.apiBaseUrl + "/v1/sellers/" + row.id ;
		method = 'PUT';
	}
}

function saveSeller() {

	var data = {
		name: $("#fm input[name=name]").val(),
		lastname: $("#fm input[name=lastname]").val(),
		phone_number: $("#fm input[name=phone_number]").val(),
		email: $("#fm input[name=email]").val(),
		avatar: $("#fm input[name=avatar]").val()
	};

	if ($('#fm input[name=change_password]').prop('checked')) {
		var password = $("#fm input[name=password]").val();
		var password_confirmation = $("#fm input[name=password_confirmation]").val();

		if (password != password_confirmation) {
			$.messager.show({	// show error message
				title: 'Error',
				msg: "La confirmacion del password no coincide"
			});

			return;
		}

		data.password = password;
	}

	$.ajax({
		url: url,
		method: method,
		data: data,
		headers: {
			authorization: Cookies.get('tmtoken')
		}
	}).then(function() {
			$('#dlg').dialog('close');		// close the dialog
			$('#dg').datagrid('reload');   // reload the user data
	}, function(err) {
			$('#dlg').dialog('close');		// close the dialog
			$.messager.show({	// show error message
				title: 'Error',
				msg: err.toString()
			});
	});
}

function deleteSeller() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar a '+row.name+' '+row.lastname+'?',function(r){
			if (r){
				$.ajax({
					url: window.apiBaseUrl + "/v1/sellers/" + row.id,
					method: 'DELETE',
					headers: {
						authorization: Cookies.get('tmtoken')
					}
				}, function() {
						$('#dg').datagrid('reload');   // reload the user data
				}, function(err) {
						$.messager.show({	// show error message
							title: 'Error',
							msg: err.toString()
						});
				});
			}
		});
	}
}

function formatPicture(value,row,index) {
	var size = 30;
	return '<img src="'+row.thumbnail+'" style="width: '+size+'px; height: '+size+'px"/>';
}

$("[name='avatar']").bind('change', function(e) {
	setImage("avatarImg", $(this).val());
});

$("#avatarImg").error(function() {
    $(this).attr("src", "images/noimage.png");
    $("[name='avatar']").css("background-color", "#fff3f3");
});

function formatPicture(value,row,index) {
	var size = 30;
	return '<img src="'+row.thumbnail+'" style="width: '+size+'px; height: '+size+'px"/>';
}

function setImage(image, src) {
	if(!src || src.length === 0) {
		src = "images/noimage.png";
	}

	$("#"+image).attr("src", src);
	$("[name='avatar']").css("background-color", "white");
}

$('#dg').datagrid({
	onLoadSuccess: function(data){
		gridResize();
	}
});
