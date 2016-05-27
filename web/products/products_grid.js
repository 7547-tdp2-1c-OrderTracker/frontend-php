var url, method;

function newProduct() {
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Producto');
	$('#fm').form('clear');
	setImage("pictureImg", "");
	//url = 'products/create_product.php';
	method = 'POST';
	url = window.apiBaseUrl + "/v1/products";
}

function editProduct() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Editar Producto');
		$('#fm').form('load',row);
		$('#brands-combo').combobox('setValue', row.brand_id);
		setImage("pictureImg", row.picture);
		//url = 'products/edit_product.php?id='+row.id;

		method = 'PUT';
		url = window.apiBaseUrl + "/v1/products/" + row.id;
	}
}

function saveProduct() {
  $.ajax({
    url: url, 
    method: method, 
    data: {
      name: $("#fm input[name='name']").val(),
      description: $("#fm input[name='description']").val(),
      picture: $("#fm input[name='picture']").val(),
      stock: $("#fm input[name='stock']").val(),
      currency: 'ARS',
      wholesalePrice: $("#fm input[name='wholesalePrice']").val(),
      retailPrice: $("#fm input[name='retailPrice']").val(),
      retailPrice: $("#fm input[name='retailPrice']").val(),
      brand_id: $("#fm input[name='brand_id']").val(),
      categories: $("#fm input[name='categories']").val()
    },
    headers: {
      authorization: Cookies.get("tmtoken")
    },
    success: function(result) {
      if(result.error) {
        $.messager.show({
          title: 'Error',
          msg: result.error.value
        });
      } else {
        $('#dlg').dialog('close');    // close the dialog
        $('#dg').datagrid('reload');  // reload the user data
      }
    }
  });	
	/*$('#fm').form('submit',{
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
	});*/
}

function deleteProduct() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar '+row.name+'?',function(r){
			if (r){
				$.post('products/delete_product.php',{id:row.id},function(result){
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
	var size = 50;
	return '<img src="'+row.picture+'" style="width: '+size+'px; height: '+size+'px"/>';
}

function formatPrice(val, row) {
    return "$"+val;
}

$("[name='picture']").bind('change', function(e) {
	setImage("pictureImg", $(this).val());
});

$("#pictureImg").error(function() {
    $(this).attr("src", "images/noimage.png");
    $("[name='picture']").css("background-color", "#fff3f3");
});

function setImage(image, src) {
	if(!src || src.length === 0) {
		src = "images/noimage.png";
	}

	$("#"+image).attr("src", src);
	$("[name='picture']").css("background-color", "white");
}

$('#brands-combo').combobox({
    url:'brands/get_brands.php',
    valueField:'id',
    textField:'name',
    onSelect:function(brand) {
    	$("[name='brand_id']").val(brand.id);
    }
});

$('#dg').datagrid({
	onLoadSuccess: function(data){
		gridResize();
	}
});
