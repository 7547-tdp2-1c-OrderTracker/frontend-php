<html>
<head>
	<title>Trackerman - Categorias</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<link rel="stylesheet" type="text/css" href="categories/category.css">
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Categorias</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newCategory()">Nueva</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editCategory()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteCategory()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid"
				toolbar="#toolbar" pagination="true" pageSize="20" rownumbers="true" fitColumns="true" singleSelect="true" method="GET">
			<thead>
				<tr>
					<th field="name">Nombre</th>
					<th field="description">Descripcion</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons" width="400" height="400">
			<div class="ftitle">Categoria</div>
			<form class="category-form" id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Descripcion:</label>
						<input name="description" class="easyui-textbox">
					</div>
	    		</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCategory()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript" src="categories/category_grid.js"></script>
</body>
</html>