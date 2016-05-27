<html>
<head>
	<title>Trackerman - Clientes</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="lib/fn.js"></script>
	<link rel="stylesheet" type="text/css" href="clients/client.css">
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Clientes</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newClient()">Nuevo</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editClient()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteClient()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="clients/get_clients.php" 
				toolbar="#toolbar" pagination="true" pageSize="20" rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="id">Id</th>
					<th field="thumbnail" align="center" formatter="formatPicture">Avatar</th>
					<th field="name">Nombre</th>
					<th field="lastname">Apellido</th>
					<th field="cuil">Cuil</th>
					<th field="company">Razón Social</th>
					<th field="address">Dirección</th>
					<th field="phone_number">Teléfono</th>
					<th field="email">Email</th>
					<th field="sellerType" formatter="formatSellerType">Tipo</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Cliente</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Apellido:</label>
						<input name="lastname" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Cuil:</label>
						<input name="cuil" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Razón Social:</label>
						<input name="company" class="easyui-textbox" required="required">
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
						<label>Tipo:</label>
					    <select name="sellerType" class="easyui-combobox" required="required" editable="false" style="width: 182.533px;">
					        <option value="retail">Minorista</option>
					        <option value="wholesale">Mayorista</option>
					    </select>
					</div>
					<div class="fitem">
						<label>Avatar URL:</label>
						<input name="avatar" type="text" class="easyuibtn">
					</div>
		    		<input type="hidden" name="lat" value="">
		    		<input type="hidden" name="lon" value="">
		    		<div id="images-container">
		    			<img id="avatarImg" class="image"/>
		    			<img id="qrImg" class="image"/>
		    		</div>
	    		</div>
	    		<div id="map-container">
	    			<div class="fitem">
						<label>Dirección:</label>
						<input name="address" type="text" class="easyuibtn">
					</div>
		    		<div id="map"></div>
				</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveClient()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript" src="clients/map.js"></script>
	<script type="text/javascript" src="clients/clients_grid.js"></script>
</body>
</html>