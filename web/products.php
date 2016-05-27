<html>
<head>
	<title>Trackerman - Productos</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>

	<script type="text/javascript" src="lib/selectize.js"></script>
	<link rel="stylesheet" type="text/css" href="products/product.css">
	<link rel="stylesheet" type="text/css" href="lib/css/selectize.css">

</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Productos</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProduct()">Nuevo</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProduct()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteProduct()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="products/get_products.php" 
				toolbar="#toolbar" pagination="true" pageSize="10" rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="id">Id</th>
					<th field="picture" formatter="formatPicture">Imagen</th>
					<th field="name">Nombre</th>
					<th field="description">Descripción</th>
					<th field="stock">Stock</th>
					<th field="wholesalePrice" formatter="formatPrice">Precio May.</th>
					<th field="retailPrice" formatter="formatPrice">Precio Min.</th>
					<th field="categories">Categorias</th>
					<th field="brand_name">Marca</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Producto</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Descripción:</label>
						<input name="description" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Stock:</label>
						<input name="stock" value="0" class="easyui-numberspinner" data-options="min:0" required="required">
					</div>
					<div class="fitem">
						<label>Precio May.:</label>
						<input name="wholesalePrice" prefix="$" class="easyui-numberbox" data-options="min:0" required="required">
					</div>
		   			<div class="fitem">
						<label>Precio Min.:</label>
						<input name="retailPrice" prefix="$" class="easyui-numberbox" data-options="min:0" required="required">
					</div>
					<div class="fitem">
						<label>Categorías:</label>
						<input name="categories" class="selectized" tabindex="-1">
					</div>
					<div class="fitem">
						<label>Marca:</label>
						<select name="brand_id" id="select-brand" class="selectized" placeholder="Buscar marca" tabindex="-1">
							<option value="" selected="selected"></option>
						</select>
					</div>
					<div class="fitem">
						<label>Imagen URL:</label>
						<input name="picture" type="text" class="easyuibtn">
					</div>
		    		<div id="images-container">
		    			<img id="pictureImg" class="image"/>
		    		</div>
	    		</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProduct()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript" src="products/products_grid.js"></script>
</body>
</html>