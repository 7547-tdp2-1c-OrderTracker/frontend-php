<html>
<head>
	<title>Trackerman - Vendedores</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<link rel="stylesheet" type="text/css" href="sellers/seller.css">
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Vendedores</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newSeller()">Nuevo</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editSeller()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteSeller()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="sellers/get_sellers.php" 
				toolbar="#toolbar" pagination="true" pageSize="20" rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="id">Id</th>
					<th field="thumbnail" align="center" formatter="formatPicture">Avatar</th>
					<th field="name">Nombre</th>
					<th field="lastname">Apellido</th>
					<th field="phone_number">Teléfono</th>
					<th field="email">Email</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Vendedor</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Apellido:</label>
						<input name="lastname" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
	   			<div class="fitem">
						<label>Teléfono:</label>
						<input name="phone_number" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Email:</label>
						<input name="email" class="easyui-textbox" required="required" validType="email">
					</div>
					<div class="fitem">
						<label>Avatar URL:</label>
						<input name="avatar" type="text" class="easyuibtn">
					</div>
					<div class="fitem">
		    		<input type="checkbox" name="change_password" value="true">Cambiar Password
		    	</div>
					<div class="fitem">
						<label>Password</label>
						<input name="password" type="password" class="easyuibtn" disabled="true">
					</div>
					<div class="fitem">
						<label>Confirmar password</label>
						<input name="password_confirmation" type="password" class="easyuibtn" disabled="true">
					</div>
	    		<div id="images-container">
	    			<img id="avatarImg" class="image"/>
	    		</div>
				</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSeller()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript" src="sellers/sellers_grid.js"></script>
</body>
</html>