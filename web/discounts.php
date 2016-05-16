<html>
<head>
	<title>Trackerman - Descuentos</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
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
					<th field="product_id">Producto</th>
					<th field="brand_id">Marca</th>
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
						<label>Producto:</label>
						<input id="products-combo">
						<input type="hidden" name="product_id" value="">
					</div>
					<div class="fitem">
						<label>Marca:</label>
						<input id="brands-combo">
		    			<input type="hidden" name="brand_id" value="">
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