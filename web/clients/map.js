		var defaultZoom = 16;
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

		$("[name='address']").bind('keydown', function(e) {
			if (e.keyCode == 13) {  // when press ENTER key
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
			}
		});