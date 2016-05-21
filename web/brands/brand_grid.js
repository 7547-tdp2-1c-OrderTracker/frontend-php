$("#dg").datagrid({
	method: "GET",
	url: window.apiBaseUrl + "/v1/brands",
	loadFilter: function(response) {
		return response.results
	}
});

var url ;
var method ;

function editBrand() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		url = window.apiBaseUrl + "/v1/brands/" + row.id;
		method = "PUT";

		$('#dlg').dialog('open').dialog('setTitle','Editar Marca');
		$('#fm').form('load',row);
		setImage("brandImg", row.picture);
	}
}

function newBrand() {
	url = window.apiBaseUrl + "/v1/brands";
	method = "POST";

	$('#dlg').dialog('open').dialog('setTitle','Nueva Marca');
	$('#fm').form('clear');
	setImage("brandImg", "");
}

function saveBrand() {
	$.ajax({
		url: url, 
		method: method, 
		data: {
			code: $(".brand-form input[name='code']").val(),
			name: $(".brand-form input[name='name']").val(),
			picture: $(".brand-form input[name='picture']").val()
		},
		success: function(result) {
			if(result.error) {
				$.messager.show({
					title: 'Error',
					msg: result.error.value
				});
			} else {
				$('#dlg').dialog('close');		// close the dialog
				$('#dg').datagrid('reload');	// reload the user data
			}
		}
	});
}

function deleteBrand() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.ajax({
			url: window.apiBaseUrl + "/v1/brands/" + row.id,
			method: 'DELETE',
			success: function(result) {
				if(result.error) {
					$.messager.show({
						title: 'Error',
						msg: result.error.value
					});
				} else {
					$('#dlg').dialog('close');		// close the dialog
					$('#dg').datagrid('reload');	// reload the user data
				}
			}
		});
	}
}

function setImage(image, src) {
	if(!src || src.length === 0) {
		src = "images/noimage.png";
	}

	$("#"+image).attr("src", src);
	$("input[name='picture']").css("background-color", "white");
}

$("input[name='picture']").bind('change', function(e) {
	setImage("brandImg", $(this).val());
});
