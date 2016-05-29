<html>
<head>
	<title>Trackerman - Agenda</title>
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
	    <p>Agenda de vendedores</p>
	</div>

	<div id="modulo3-contenido">
		
		<div id="sellers">
			<b>Seleccione un vendedor:</b>
			<input id="sellers-combo">
	    </div>

    	<div class="left">
			<table>
				<tr>
					<td class="title">Clientes no asignados</td>
				</tr>
				<tr>
					<td id="items"></td>
				</tr>
			</table>
		</div>

		<div class="right">
			<table>
				<tr>
					<td class="title">Lunes</td>
					<td class="title">Martes</td>
					<td class="title">Miércoles</td>
					<td class="title">Jueves</td>
					<td class="title">Viernes</td>
				</tr>
				<tr>
					<td id="day_1" class="drop"></td>
					<td id="day_2" class="drop"></td>
					<td id="day_3" class="drop"></td>
					<td id="day_4" class="drop"></td>
					<td id="day_5" class="drop"></td>
				</tr>
			</table>
		</div>

		<div id="trasfer">
			<b>Transferir clientes a:</b>
			<input id="transfer-to-combo">
			<a id="transfer-btn" class="easyui-linkbutton">Transferir</a>
	    </div>
	</div>

	<link rel="stylesheet" type="text/css" href="schedule/schedule.css">
	<script type="text/javascript" src="schedule/schedule.js"></script>

	<script type="text/javascript">
		$.extend($.fn.combobox.methods, {
			deleteItem: function(jq, index){
				return jq.each(function(){
					var state = $.data(this, 'combobox');
					$(this).combobox('getData').splice(index,1);
					var panel = $(this).combobox('panel');
					panel.children('.combobox-item:gt('+index+')').each(function(){
						var id = $(this).attr('id');
						var i = id.substr(state.itemIdPrefix.length+1);
						$(this).attr('id', state.itemIdPrefix+'_'+(parseInt(i)-1));
					});
					panel.children('.combobox-item:eq('+index+')').remove();
				})
			}
		});

		$('#sellers-combo').combobox({
	        url:'sellers/get_sellers.php',
	        valueField:'id',
	        textField:'email',
	        onSelect: selectSeller
	    });

	    $('#transfer-to-combo').combobox({
	        valueField:'id',
	        textField:'email',
	        onSelect: selectTransferSeller
	    });

	    $('#transfer-btn').bind('click', transferClients);
	</script>
</body>
</html>