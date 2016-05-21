var url;

function formatRestriction(entity, row) {
	if (row.product) {
		return "Producto: " + row.product.name;
	} else if (row.brand) {
		return "Marca: " + row.brand.name;
	} else {
		return "";
	}
}

function newDiscount() {
	$('#dlg').dialog('open').dialog('setTitle','Nuevo Descuento');
	$('#fm').form('clear');
	setDate("begin", new Date());
	url = 'discounts/create_discount.php';
}

function editDiscount() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Editar Descuento');
		$('#fm').form('load',row);
		setDate("begin", row.begin_date);
		setDate("end", row.end_date);
		$('#products-combo').combobox('setValue', row.product_id);
		$('#brands-combo').combobox('setValue', row.brand_id);
		url = 'discounts/edit_discount.php?id='+row.id;
	}
}

function saveDiscount() {
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

function deleteDiscount() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$.messager.confirm('Confirm','¿Está seguro de que desea eliminar '+row.name+'?',function(r){
			if (r){
				$.post('discounts/delete_discount.php',{id:row.id},function(result){
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

function setDate(field, date) {
	$('#'+field).datebox('setValue', formatDate(date));

	var saveFormat = moment(date).format('YYYY-MM-DD')+'T00:00:00.000Z';
	$("[name='"+field+"_date']").val(saveFormat);
}

$('#begin').datebox({
	onSelect: function(date) {
		setDate("begin", date);
	}
});

$('#end').datebox({
	onSelect: function(date) {
		setDate("end", date);
	}
});


$('#products-combo').combobox({
    url:'products/get_products.php',
    valueField:'id',
    textField:'name',
    onSelect:function(product) {
    	$("[name='product_id']").val(product.id);
    }
});

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
