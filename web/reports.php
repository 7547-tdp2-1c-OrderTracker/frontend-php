<html>
<head>
	<title>Trackerman - Reportes</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="lib/jquery.min.js"></script>    
    <script type="text/javascript">

		// Load the Visualization API and the corechart package.
		google.charts.load('current', {'packages':['corechart', 'bar']});



		function refreshCharts() {
			//cambia el año
			drawTop10Sellers();
			//cambia el mes y año y vendedor
			drawMonthSalesComparison();
		};

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(refreshCharts);
		
		// guardar la referencia a ajax porque la pisa mas adelante el otro include de jquery
		var ajax = $.ajax.bind($);

		function drawTop10Sellers() {
			var year = $("input[name=dateFilter]").val().split("/")[1];
			var url = window.apiBaseUrl + "/v1/report/sellers/top10";
			if (year) {
				url += "?year=" + year;
			}

			ajax(url).then(function(response) {
    			// Create the data table.
    			var data = new google.visualization.DataTable();
    			data.addColumn('string', 'Topping');
    			data.addColumn('number', 'Slices');
    			data.addRows(response.top10.map(function(seller) {
					return [seller.lastName+', '+seller.name, seller.total]
				}));

    			// Set chart options
    			var options = {
    				'title':'Top 10 vendedores ' + response.year,
    				'is3D': true,
    				'width':400,
    				'height':300
    			};

    			// Instantiate and draw our chart, passing in some options.
    			var chart = new google.visualization.PieChart(document.getElementById('top10chart'));
    			chart.draw(data, options);
        	});
		}


		function drawMonthSalesComparison() {
			var mmYyyy = $("input[name=dateFilter]").val();
			if ($("input[name=dateFilter]").val().match(/[0-9]{2}\/[0-9]{4}/) == null) {
				mmYyyy = $.datepicker.formatDate( "mm/yy", new Date() );
			}
			var dates = mmYyyy.split("/");
			var currentMonth = dates[0];
			var currentYear = dates[1];
			var pastYear = (currentYear - 1).toString();


			var url = window.apiBaseUrl + "/v1/report/monthSales?date="+mmYyyy;
			var seller = $("select[id=sellers-combo]").val();
			if (seller.match(/[0-9]{1,}/) != null) {
				url += "&seller="+seller;
			}

			//ajax(url).then(function(response) {
				var data = google.visualization.arrayToDataTable([
					['Año', pastYear, currentYear],
					['Ventas', 8175000, 8008000]
				]);

				var options = {
					chart: {
						title: 'Ventas del mes en curso ('+currentMonth+') en comparación con el año anterior',
						subtitle: 'Comparador de ventas entre 2 años sucesivos'
					},
					hAxis: {
						title: 'Total Vendido ($)'
					},
					vAxis: {
						title: 'Año'
					},
					bars: 'horizontal',
					series: {
						0: {axis: pastYear},
						1: {axis: currentYear}
					},
					axes: {
						x: {
							pastYear: {label: currentMonth/pastYear+' Ventas', side: 'top'},
							currentYear: {label: currentMonth/currentYear+' Ventas'}
						}
					},
					width: 500,
					height: 300
				};
				var material = new google.charts.Bar(document.getElementById('monthSalesComparison'));
				material.draw(data, options);
			//});
		}

      //-------------------------------------------
		function populateReport() {
			console.log('Poluate report');
		};
		$.ajax({
			url: window.apiBaseUrl + '/v1/sellers'
		}).then(function(data) {
			$('<option>').val(null).text('Todos').appendTo('#sellers-combo');
			$(data.results).map(function () {
				return $('<option>').val(this.id).text(this.lastname+', '+this.name);
			}).appendTo('#sellers-combo');
		});

    </script>
    <style>
	.ui-datepicker-calendar {
    	display: none;
    };
    #filters label {
    	font-weight: bold;
    }
    .inline {
    	float: left;
    	padding-left: 20px;
    }
    .report-subtitle {
    	text-decoration: underline;
    	padding-top: 20px;
    	padding-bottom: 10px;
    	font-weight: bold;
    }
    .report-chart {
    	padding: 15 0 0 200;
    	border: 1px solid #ccc;
    }
</style>
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Reportes</p>
	</div>

	<div id="modulo3-contenido">
		<div class="report-subtitle">Filters</div>
		<div id="filters">
			<div id="sellersFilter" class="inline">
				<label for="seller">Seleccione un vendedor:</label>
				<select id="sellers-combo"></select>
		    </div>
		    <div id="dateFilter" class="inline">
			    <label for="dateFilter">Mes y Año:</label>
	    		<input name="dateFilter" id="dateFilter" class="date-picker" />
		    </div>
		</div>

		<div class="report-subtitle" style="padding-top:50px;">Gráficos</div>
		<div id="monthSalesComparison" class="report-chart"></div>
		<div id="top10chart" class="report-chart"></div>

	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
	<script type="text/javascript">
	    $(function() {
			$('.date-picker').datepicker(
				{
					dateFormat: "mm/yy",
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					onClose: function(dateText, inst) {


						function isDonePressed(){
							return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
						}

						if (isDonePressed()){
							var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
							var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
							$(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

							$('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
              				refreshCharts();
						}
					},
					beforeShow : function(input, inst) {

						inst.dpDiv.addClass('month_year_datepicker')

						if ((datestr = $(this).val()).length > 0) {
							year = datestr.substring(datestr.length-4, datestr.length);
							month = datestr.substring(0, 2);
							$(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
							$(this).datepicker('setDate', new Date(year, month-1, 1));
							$(".ui-datepicker-calendar").hide();
						}
					}
			})
		});
	</script>
</body>
</html>