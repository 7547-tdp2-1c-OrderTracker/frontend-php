$("#dg").datagrid({
	/*method: "GET"
	url: window.apiBaseUrl + "/v1/brands"*/
	loader: function(params, success, error) {
		$.ajax({
			url: window.apiBaseUrl + "/v1/clients?page=" + params.page + "&rows=" + params.rows,
			method: "GET",
			success: success,
			error: error,
			headers: {
				authorization: Cookies.get("tmtoken")
			}
		});
	}
});

var url;
var method;

function newClient() {
	updateMap();
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Cliente');
	$('#fm').form('clear');
	setImage("avatarImg", "");
	setImage("qrImg", "");
	url = window.apiBaseUrl + "/v1/clients";
	method = 'POST';
}

function editClient() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		updateMap(new google.maps.LatLng(row.lat, row.lon));
		$('#dlg').dialog('open').dialog('setTitle','Editar Cliente');
		$('#fm').form('load',row);
		setImage("avatarImg", row.avatar);
		setImage("qrImg", "http://www.barcodes4.me/barcode/qr/qr.png?value="+row.id+"&size=6&ecclevel=0");
		url = window.apiBaseUrl + "/v1/clients/" + row.id;
		method = 'PUT';
	}
}

function saveClient() {
	$.ajax({
		url: url, 
		method: method, 
		data: {
			name: $("#fm input[name='name']").val(),
			lastname: $("#fm input[name='lastname']").val(),
			cuil: $("#fm input[name='cuil']").val(),
			company: $("#fm input[name='company']").val(),
			phone_number: $("#fm input[name='phone_number']").val(),
			email: $("#fm input[name='email']").val(),
			sellerType: $("#fm input[name='sellerType']").val(),
			address: $("#fm input[name='address']").val(),
			avatar: $("#fm input[name='avatar']").val(),
			lat: $("#fm input[name='lat']").val(),
			lon: $("#fm input[name='lon']").val()
		},
		headers: {
			authorization: Cookies.get("tmtoken")
		},
    success: function(result) {
      $('#dlg').dialog('close');    // close the dialog
      $('#dg').datagrid('reload');  // reload the user data
    },
    error: function(xhr) {
      $.messager.show({
        title: 'Error',
        msg: xhr.responseJSON.error ? xhr.responseJSON.error.value : "Error desconocido"
      });
   	}
	});	

}

function deleteClient() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar a '+row.name+' '+row.lastname+'?',function(r){
			if (r){
				$.post('clients/delete_client.php',{id:row.id},function(result){
					if (result.success){
						$('#dg').datagrid('reload');   // reload the user data
					} else {
						$.messager.show({	// show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
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

function setImage(image, src) {
	if(!src || src.length === 0) {
		src = "images/noimage.png";
	}

	$("#"+image).attr("src", src);
	$("[name='avatar']").css("background-color", "white");
}

function formatSellerType(str) {
	if (str === "wholesale") return "Mayorista";
	if (str === "retail") return "Minorista";
	return "-";
}

$('#dg').datagrid({
	onDblClickCell: editClient,
	onLoadSuccess: function(data){
		gridResize();
	}
});
