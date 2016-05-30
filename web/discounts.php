<html>
<head>
	<title>Trackerman - Descuentos</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<script type="text/javascript" src="lib/selectize.js"></script>
	<link rel="stylesheet" type="text/css" href="lib/css/selectize.css">
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Descuentos</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newDiscount()">Nuevo</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editDiscount()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteDiscount()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="discounts/get_discounts.php" 
				toolbar="#toolbar" pagination="true" pageSize="20" rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="id">Id</th>
					<th field="name">Nombre</th>
					<th field="percent">Porcentaje</th>
					<th field="begin_date" formatter="formatDate">Desde</th>
					<th field="end_date" formatter="formatDate">Hasta</th>
					<th field="product_id" formatter="formatRestriction">Restriccion</th>
					<th field="min_quantity">Cantidad Mínima</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Descuento</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox" required="required">
					</div>
					<div class="fitem">
						<label>Porcentaje:</label>
						<input name="percent" class="easyui-numberbox" required="required">
					</div>
					<div class="fitem">
						<label>Desde:</label>
						<input id="begin" required="required">
						<input type="hidden" name="begin_date" value="">
					</div>
		   			<div class="fitem">
						<label>Hasta:</label>
						<input id="end" required="required">
						<input type="hidden" name="end_date" value="">
					</div>
					<div class="fitem">
 						<input type="radio" name="promotion_type" value="promotion_type_product">Por Producto<br>
 						<input type="radio" name="promotion_type" value="promotion_type_brand">Por Marca<br>
					</div>
					<div class="fitem select-product">
						<label>Producto:</label>
						<select name="product_id" id="select-product" class="selectized" placeholder="Buscar producto" tabindex="-1">
							<option value="" selected="selected"></option>
						</select>
					</div>
					<div class="fitem select-brand">
						<label>Marca:</label>
						<select name="brand_id" id="select-brand" class="selectized" placeholder="Buscar marca" tabindex="-1">
							<option value="" selected="selected"></option>
						</select>
					</div>
					<div class="fitem">
						<label>Cantidad Mínima:</label>
						<input name="min_quantity" class="easyui-numberbox">
					</div>
				</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveDiscount()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="discounts/discounts.css">
	<script type="text/javascript" src="discounts/discounts_grid.js"></script>
</body>
</html>