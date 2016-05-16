var url;

function orderDetail() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Detalle del pedido');
		$('#fm').form('load',row);
		$('#fm').form('load',{date_created:formatDate(row.date_created)});
		$('#products').datagrid({
			url:'orders/get_order_products.php?id='+row.id,
			columns:[[
				{field:'id', title:'Id'},
				{field:'image', title:'Imagen',
					formatter: function(value,row,index) {
						return '<img src="'+row.thumbnail+'" style="width: 80px; height: 80px"/>';
					}
				},
				{field:'name', title:'Descripción'},
				{field:'unit_price', title:'Precio U.'},
				{field:'quantity', title:'Cantidad'}
			]]
		});
		url = 'orders/edit_order.php?id='+row.id;
	}
}

function saveOrder() {
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

function formatPrice(val, row) {
    return val;  // si se cambia rompe el filtro
}

function formatState(val) {
	if (val === "draft") return "Borrador";
	if (val === "cancelled") return "Cancelado";
	if (val === "confirmed") return "Confirmado";
	if (val === "delivered") return "Entregado";
	if (val === "intransit") return "En Transito";
	if (val === "prepared") return "Preparado";
	
    return val;
}
