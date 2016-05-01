<html>
<head>
	<meta charset="UTF-8">
	<title>Trackerman - Clientes</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
	<script type="text/javascript" src="lib/fn.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="clients/clients_grid.js"></script>
	<link rel="stylesheet" type="text/css" href="clients/client.css">
	<?php
		include 'general/header.php';
	?>
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p><?php echo "Clientes"; ?></p>
	</div>

	<div id="modulo3-contenido">
		<div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newClient()">Nuevo</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editClient()">Editar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteClient()">Eliminar</a>
		</div>
		<table id="dg" class="easyui-datagrid" url="clients/get_clients.php" 
				toolbar="#toolbar" pagination="true" pageSize="16" pageList="[16,32,48]"
				rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="name">Nombre</th>
					<th field="lastname">Apellido</th>
					<th field="cuil">Cuil</th>
					<th field="address">Dirección</th>
					<th field="phone_number">Teléfono</th>
					<th field="email">Email</th>
					<th field="sellerType">Tipo</th>
				</tr>
			</thead>
		</table>
		
		<div id="dlg" class="easyui-dialog" style="width:700px;height:500px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
			<div class="ftitle">Cliente</div>
			<form id="fm" method="post" novalidate>
				<div id="form-container">
					<div class="fitem">
						<label>Nombre:</label>
						<input name="name" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Apellido:</label>
						<input name="lastname" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Cuil:</label>
						<input name="cuil" class="easyui-textbox">
					</div>
		   			<div class="fitem">
						<label>Teléfono:</label>
						<input name="phone_number" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Email:</label>
						<input name="email" class="easyui-textbox" validType="email">
					</div>
					<div class="fitem">
						<label>Tipo:</label>
						<input name="sellerType" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Avatar:</label>
						<input name="avatar" class="easyui-textbox">
					</div>
					<div class="fitem">
						<label>Thumbnail:</label>
						<input name="thumbnail" class="easyui-textbox">
					</div>
		    		<input type="hidden" name="lat" value="">
		    		<input type="hidden" name="lon" value="">
	    		</div>
	    		<div id="map-container">
	    			<div class="fitem">
						<label>Dirección:</label>
						<input name="address" type="text" class="addrbtn">
					</div>
		    		<div id="map" style="width: 300px; height: 300px;"></div>
				</div>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveClient()" style="width:90px">Guardar</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
		</div>
	</div>
	<script type="text/javascript">
		var defaultZoom = 15;
		var map;
		var marker;
		var geocoder;
		
		function updateMap(location) {
		    if(!map) {
			    var myOptions = {
			        zoom: defaultZoom,
			        mapTypeId: 'roadmap',
			        mapTypeControl: false,
			        streetViewControl: false
			    };

		    	map = new google.maps.Map($('#map')[0], myOptions);
			    geocoder = new google.maps.Geocoder();

			    marker = new google.maps.Marker({
			        position: location,
			        map: map,
			        draggable: true
			    });

			    marker.addListener('dragend', function() {
				    var location = marker.getPosition();
					map.setCenter(location);

				    geocoder.geocode({'location': location}, function(results, status) {
					    if(status === google.maps.GeocoderStatus.OK) {
					    	var addr = results[0].formatted_address;
					    	addr = addr.substr(0, addr.indexOf(","));
					    	$("[name='address']").val(addr);

					    	$("[name='lat']").val(location.toJSON().lat);
							$("[name='lon']").val(location.toJSON().lng);
					    }
					    else {
					      window.alert('No se pudo obtener la dirección en el mapa: ' + status);
					    }
					});
			  	});
		    }

			if(location) {
			    map.setCenter(location);
			    map.setZoom(defaultZoom);
			    marker.setPosition(location);			    
    
				$("[name='lat']").val(location.toJSON().lat);
				$("[name='lon']").val(location.toJSON().lng);
			}
		}

		$("[name='address']").bind('keydown', fn.debounce(function(e) {
				var address = $("[name='address']").val();

			    geocoder.geocode({ 'address': address, 'componentRestrictions':{'country':'AR'/*, 'locality':'Buenos Aires'*/}}, 
					function(results, status) {
						if (status === google.maps.GeocoderStatus.OK) {
							updateMap(results[0].geometry.location);
						}
						else {
							alert("No se pudo obtener la ubicación en el mapa: " + status);
						}
					}
				);
		}, 440));
	</script>

</body>
</html>