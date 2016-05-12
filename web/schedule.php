<html>
<head>
	<title>Trackerman - Agenda</title>	
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
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
	</div>

	<link rel="stylesheet" type="text/css" href="schedule/schedule.css">
	<script type="text/javascript" src="schedule/schedule.js"></script>

	<script type="text/javascript">
		$('#sellers-combo').combobox({
	        url:'sellers/get_sellers.php',
	        valueField:'id',
	        textField:'email',
	        onSelect: populateSchedule
	    });
	</script>
</body>
</html>