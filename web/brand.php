<html>
<head>
	<title>Trackerman - Marcas</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<link rel="stylesheet" type="text/css" href="brands/brand.css">
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Marcas</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newBrand()">Nueva</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editBrand()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteBrand()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid"
				toolbar="#toolbar" pagination="true" pageSize="20" rownumbers="true" fitColumns="true" singleSelect="true" method="GET">
			<thead>
				<tr>
					<th field="code">Codigo</th>
					<th field="picture" align="center" formatter="formatPicture">Logo</th>
					<th field="name">Nombre</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons" width="400" height="400">
			<div class="ftitle">Marca</div>
			<form class="brand-form" id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Codigo:</label>
						<input name="code" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Imagen URL:</label>
						<input name="picture" type="text" class="easyuibtn">
					</div>
		    		<div id="images-container">
		    			<img id="brandImg" class="image"/>
		    		</div>
	    		</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBrand()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript" src="brands/brand_grid.js"></script>
</body>
</html>