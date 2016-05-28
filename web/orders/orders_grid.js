var url;

$("#dg").datagrid({
	/*method: "GET"
	url: window.apiBaseUrl + "/v1/brands"*/
	loader: function(params, success, error) {
		$.ajax({
			url: window.apiBaseUrl + "/v1/orders?page=1&rows=9999999",
			method: "GET",
			success: success,
			error: error,
			headers: {
				authorization: Cookies.get("tmtoken")
			}
		});
	}
});

function orderDetail() {
	var row = $('#dg').datagrid('getSelected');
	if(row) {
		$('#dlg').dialog('open').dialog('setTitle','Detalle del pedido');
		$('#fm').form('load',row);
		$('#fm').form('load',{date_created:formatDate(row.date_created)});
		$('#status').combobox('loadData', getPosibleStates(row.status));
		$('#status').combobox('select', formatStatus(row.status));
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

var states = [
	{text: 'Borrador', value: 'draft'},
	{text: 'Confirmado', value: 'confirmed'},
	{text: 'Preparado', value: 'prepared'},
	{text: 'En camino', value: 'intransit'},
	{text: 'Entregado', value: 'delivered'},
	{text: 'Cancelado', value: 'cancelled'}
];

function formatStatus(val) {
    var text;
    $.each(states, function(i, state) {
		if(state.value === val) {
			text = state.text;
			return false;
		}
    });
    return text;
}

function getPosibleStates(currState) {
	switch(currState) {
		case 'draft':
			return [states[0], states[1], states[5]];
	    case 'confirmed':
			return [states[1], states[2], states[5]];
	    case 'prepared':
	    	return [states[2], states[1], states[3], states[5]];
	    case 'intransit':
			return [states[3], states[2], states[4], states[5]];
	    case 'delivered':
	    	return [states[4]];
	    case 'cancelled':
			return [states[5]];
	}
}

setTimeout(gridResize, 2500);
/*$(window).resize(function() {
});*/
