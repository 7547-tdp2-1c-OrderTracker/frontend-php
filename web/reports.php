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
			//cambia el mes y año
			drawTopBrands();
		};

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(refreshCharts);
		
		// guardar la referencia a ajax porque la pisa mas adelante el otro include de jquery
		var ajax = $.ajax.bind($);

		function drawTop10Sellers() {
			var year = getDatePickerInfo().currentYear;
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
					return [seller.lastname+', '+seller.name, seller.total]
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

		function getDatePickerInfo() {
			var mmYyyy = $("input[name=datepicker]").val();
			if (mmYyyy.match(/[0-9]{2}\/[0-9]{4}/) == null) {
				mmYyyy = $.datepicker.formatDate( "mm/yy", new Date() );
			}
			var dates = mmYyyy.split("/");
			return {currentMonth: dates[0], currentYear: dates[1]};
		}

		function drawTopBrands() {
			var picked = getDatePickerInfo();
			var url = window.apiBaseUrl + "/v1/report/brandsSales?date="+picked.currentMonth+'-'+picked.currentYear;

			var seller = $("#sellers-combo").val();
			var customTitle = 'Top de Marcas más vendidas. sobre el mes seleccionado ('+$.datepicker.formatDate( "MM", new Date( picked.currentYear, picked.currentMonth - 1, 1 ))+')'
			if (seller != null && seller.match(/[0-9]{1,}/) != null) {
				url += "&seller_id="+seller;
				customTitle += ' de '+$("#sellers-combo option:selected").text();
			}

			ajax(url).then(function(response) {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Topping');
				data.addColumn('number', 'Slices');
				data.addRows(response.report.map(function(report) {
					return [report.brand.name+'('+report.items_amount+')', report.total_amount];
				}));

				var options = {
					title: 'Top de Marcas más vendidas. sobre el mes seleccionado ('+$.datepicker.formatDate( "MM", new Date( picked.currentYear, picked.currentMonth - 1, 1 ))+').',
					pieSliceText: 'label',
					pieHole: 0.4,
					width: 500,
					height: 300	
				};

				var chart = new google.visualization.PieChart(document.getElementById('topBrands'));
				chart.draw(data, options);
			});
		}

		function drawMonthSalesComparison() {
			var picked = getDatePickerInfo();
			var currentMonth = picked.currentMonth;
			var currentYear = picked.currentYear;
			var pastYear = (currentYear - 1).toString();


			var url = window.apiBaseUrl + "/v1/report/monthSales?date="+currentMonth+'-'+currentYear;
			var seller = $("#sellers-combo").val();
			var customTitle = 'Ventas del mes en curso ('+$.datepicker.formatDate( "MM", new Date( currentYear, currentMonth - 1, 1 ))+') en comparación con el año anterior'
			if (seller != null && seller.match(/[0-9]{1,}/) != null) {
				url += "&seller_id="+seller;
				customTitle += ' de '+$("#sellers-combo option:selected").text();
			}

			ajax(url).then(function(response) {
				var data = google.visualization.arrayToDataTable([
					['Año', pastYear, currentYear],
					['Ventas', response.report[1].amount, response.report[0].amount]
				]);

				var options = {
					chart: {
						title: customTitle,
						subtitle: $.datepicker.formatDate( "MM yy", new Date( currentYear, currentMonth - 1, 1 )) + ' '+response.currency+' '+ response.report[0].amount
					},
					hAxis: {
						title: 'Total Vendido ('+response.currency+')'
					},
					bars: 'horizontal',
					series: {
						0: {axis: pastYear},
						1: {axis: currentYear}
					},
					axes: {
						x: {}
					},
					width: 500,
					height: 300
				};
				options.axes.x[pastYear] = {label: currentMonth+'-'+pastYear+' Ventas', side: 'top'};
				options.axes.x[currentYear] = {label: currentMonth+'-'+currentYear+' Ventas'};
				var material = new google.charts.Bar(document.getElementById('monthSalesComparison'));
				material.draw(data, options);
			});
		}

      //-------------------------------------------
		$.ajax({
			url: window.apiBaseUrl + '/v1/sellers'
		}).then(function(data) {
			$('<option>').val(null).text('Todos').appendTo('#sellers-combo');
			$(data.results).map(function () {
				return $('<option>').val(this.id).text(this.lastname+', '+this.name);
			}).appendTo('#sellers-combo');
			$('#sellers-combo').change(function() {
				drawMonthSalesComparison();
				var selected = $("#sellers-combo option:selected").val()
				if (selected.match(/[0-9]{1,}/) == null) $('#top10chart').show();
				else $('#top10chart').hide();
			});
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
		<div class="report-subtitle">Filtros</div>
		<div id="filters">
			<div id="sellersFilter" class="inline">
				<label for="seller">Seleccione un vendedor:</label>
				<select id="sellers-combo"></select>
		    </div>
		    <div id="dateFilter" class="inline">
			    <label for="dateFilter">Mes y Año:</label>
	    		<input name="datepicker" id="datepicker" class="date-picker" />
		    </div>
		</div>

		<div class="report-subtitle" style="padding-top:50px;">Gráficos</div>
		<div id="monthSalesComparison" class="report-chart"></div>
		<div id="topBrands" class="report-chart inline" style="padding-left:inherit"></div>
		<div id="top10chart" class="report-chart" style="padding-left:800px"></div>

	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
    <script src="https://cdn.rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-es.js"></script>
	<script type="text/javascript">
	    $(function() {
	    	$.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
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
							$(this).datepicker('setDate', new Date(year, month, 1));

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