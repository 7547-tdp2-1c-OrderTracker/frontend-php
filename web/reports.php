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

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawMonthSalesComparison);
		google.charts.setOnLoadCallback(drawTop10Sellers);
		
    // guardar la referencia a ajax porque la pisa mas adelante el otro include de jquery
    var ajax = $.ajax.bind($);

		function drawTop10Sellers() {
      ajax(window.apiBaseUrl + "/v1/report/sellers/top10")
        .then(function(response) {
    			// Create the data table.
    			var data = new google.visualization.DataTable();
    			data.addColumn('string', 'Topping');
    			data.addColumn('number', 'Slices');
    			data.addRows(response.top10.map(function(seller) {
            return [seller.name, seller.total]
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
			var data = google.visualization.arrayToDataTable([
				['Año', '2015', '2016'],
				['Ventas', 8175000, 8008000]
			]);

			var options = {
				chart: {
					title: 'Ventas del mes en curso en comparación con el año anterior',
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
					0: {axis: '2016'},
					1: {axis: '2015'}
				},
				axes: {
					x: {
						2015: {label: '05/2015 Ventas', side: 'top'},
						2016: {label: '05/2016 Ventas'}
					}
				},
				width: 500,
				height: 300
			};
			var material = new google.charts.Bar(document.getElementById('monthSalesComparison'));
			material.draw(data, options);
		}

      //-------------------------------------------
		function populateReport() {
			console.log('Poluate report');
		};
		$('#sellers-combo').combobox({
			url:'sellers/get_sellers.php',
			valueField:'id',
			textField:'email',
			onSelect: populateReport()
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
				<input id="sellers-combo">
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