<html>
<head>
	<title>Trackerman - Pedidos</title>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<script type="text/javascript" src="lib/fn.js"></script>
	<script type="text/javascript" src="lib/moment.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
	<?php
		include 'general/header.php';
	?>
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
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editOrder()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelOrder()">Cancelar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="orders/get_orders.php" 
				toolbar="#toolbar" pagination="true" pageSize="16" pageList="[16,32,48]"
				rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="id">Nro Orden</th>
					<th field="client_name">Cliente</th>
					<th field="total_price">Monto</th>
					<th field="status">Estado</th>
					<th field="seller_id">Vendedor</th>
					<th field="date_created" formatter="formatDate">Fecha Creación</th>
					<th field="items">Bultos</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" style="width:700px;height:500px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Ordern</div>
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

	<link rel="stylesheet" type="text/css" href="orders/orders.css">
	<script type="text/javascript" src="orders/orders_grid.js"></script>

</body>
</html>