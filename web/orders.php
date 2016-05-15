<html>
<head>
	<title>Trackerman - Pedidos</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<script type="text/javascript" src="lib/fn.js"></script>
	<script type="text/javascript" src="lib/moment.js"></script>
	<script type="text/javascript" src="lib/datagrid-filter.js"></script>
</head>
<body>
	<?php
		include 'general/general.php';
	?>
    
	<div id="modulo2">
	    <p>Pedidos</p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="orderDetail()">Ver detalle</a>
		</div>
		<table id="dg" rownumbers="true" toolbar="#toolbar" singleSelect="true" url="orders/get_orders.php">
			<thead>
				<tr>
					<th data-options="field:'id'">Nro Orden</th>
					<th data-options="field:'client_name'">Cliente</th>
					<th data-options="field:'company'">Razón social</th>
					<th data-options="field:'total_price', width:80, align:'center'" formatter="formatPrice">Monto</th>
					<th data-options="field:'status', width:80, align:'center'">Estado</th>
					<th data-options="field:'seller_id', align:'center'">Vendedor</th>
					<th data-options="field:'date_created', width:120, align:'center'" formatter="formatDate">Fecha Creación</th>
					<th data-options="field:'items', align:'center'">Bultos</th>
				</tr>
			</thead>
		</table>
	<!-- <div id="dlg" class="easyui-dialog" style="width:700px;height:500px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Orden</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nro Pedido:</label>
						<p name="id"></p>
					</div>
					<div class="fitem">
						<label>Cliente:</label>
						<p name="client"></p>
					</div>
					<div class="fitem">
						<label>Monto:</label>
						<p name="total_price"></p>
					</div>
		   			<div class="fitem">
						<label>Estado:</label>
						<input name="status" class="easyui-textbox" />
					</div>
					<div class="fitem">
						<label>Vendedor:</label>
						<p name='seller_id'></p>
					</div>
					<div class="fitem">
						<label>Fecha creación:</label>
						<p name='date_created'></p>
					</div>
					<div class="fitem">
						<label>Productos:</label>
						<input name="avatar" class="easyui-textbox">
					</div>
	    		</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveOrder()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
 -->
	<link rel="stylesheet" type="text/css" href="orders/orders.css">
	<script type="text/javascript" src="orders/orders_grid.js"></script>
	<script type="text/javascript" src="orders/filters.js"></script>
</body>
</html>