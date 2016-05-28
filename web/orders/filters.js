/*$(function(){
	var dg = $('#dg').datagrid({
		filterBtnIconCls:'icon-filter'
	});
	dg.datagrid('enableFilter', [{
		field:'total_price',
		type:'numberbox',
		op:['equal','notequal','less','greater']
	},{
		field:'date_created',
		type:'datebox',
		//options:{},
		op:['equal','notequal','lessorequal','greaterorequal']
	},{
		field:'status',
		type:'combobox',
		options:{
			panelHeight:'auto',
			data:[
				{value:'',text:'Todos'},
				{value:'Borrador',text:'Borrador'},
				{value:'Confirmado',text:'Confirmado'},
				{value:'Cancelado',text:'Cancelado'},
				{value:'En camino',text:'En camino'},
				{value:'Entregado',text:'Entregado'},
				{value:'Preparado',text:'Preparado'}
			],
			onChange:function(value){
				if(value == '') {
					dg.datagrid('removeFilterRule', 'status');
				} 
				else {
					dg.datagrid('addFilterRule', {
						field: 'status',
						op: 'equal',
						value: value
					});
				}
				dg.datagrid('doFilter');
			}
		}
	}]);
});*/
