var url;

function newClient() {
	updateMap();
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Cliente');
	$('#fm').form('clear');
	setImage("avatarImg", "");
	setImage("qrImg", "");
	url = 'clients/create_client.php';
}

function editClient() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		updateMap(new google.maps.LatLng(row.lat, row.lon));
		$('#dlg').dialog('open').dialog('setTitle','Editar Cliente');
		$('#fm').form('load',row);
		setImage("avatarImg", row.avatar);
		setImage("qrImg", "http://www.barcodes4.me/barcode/qr/qr.png?value="+row.id+"&size=6&ecclevel=0");
		url = 'clients/edit_client.php?id='+row.id;
	}
}

function saveClient() {
	$('#fm').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if(result.errorMsg) {
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg').dialog('close');		// close the dialog
				$('#dg').datagrid('reload');	// reload the user data
			}
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
