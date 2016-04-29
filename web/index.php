<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trackerman - Clientes</title>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body>
	<div id="toolbar">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newClient()">Nuevo</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editClient()">Editar</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteClient()">Eliminar</a>
	</div>
	<table id="dg" class="easyui-datagrid" url="clients/get_clients.php" style="padding:10px 20px"
			toolbar="#toolbar" pagination="true" pageSize="20"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="name">Nombre</th>
				<th field="lastname">Apellido</th>
				<th field="cuil">Cuil</th>
				<th field="address">Dirección</th>
				<th field="phone_number">Teléfono</th>
				<th field="email">Email</th>
				<th field="sellerType">Tipo</th>
			</tr>
		</thead>
	</table>
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Cliente</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>Nombre:</label>
				<input name="name" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Apellido:</label>
				<input name="lastname" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Cuil:</label>
				<input name="cuil" class="easyui-textbox">
			</div>
			<div class="fitem">
				<label>Teléfono:</label>
				<input name="phone_number" class="easyui-textbox">
			</div>
			<div class="fitem">
				<label>Email:</label>
				<input name="email" class="easyui-textbox" required="true" validType="email">
			</div>
			<div class="fitem">
				<label>Tipo:</label>
				<input name="sellerType" class="easyui-textbox">
			</div>
			
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveClient()" style="width:90px">Guardar</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
	</div>
	<script type="text/javascript">
		var url;
		function newClient() {
			$('#dlg').dialog('open').dialog('setTitle','Nuevo Cliente');
			$('#fm').form('clear');
			url = 'clients/create_client.php';
		}
		function editClient() {
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar Cliente');
				$('#fm').form('load',row);
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
					if (result.errorMsg){
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
			if (row){
				$.messager.confirm('Confirm','Está seguro de que desea eliminar este cliente?',function(r){
					if (r){
						$.post('clients/delete_client.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
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
	</script>
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
		.fitem input{
			width:160px;
		}
	</style>
</body>
</html>