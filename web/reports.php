<html>
<head>
	<title>Trackerman - Reportes</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
		  ['darios3@gmail.com', 100],
		  ['guido321@gmail.com', 50],
		  ['damian.arias@gmail.com', 10],
		  ['liomessi@gmail.com', 200],
		  ['smpiano@gmail.com', 15]
        ]);

        // Set chart options
        var options = {'title':'Top 10 vendedores 2016',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
	<?php
		include 'general/general.php';
	?>

	<div id="modulo2">
	    <p>Reportes</p>
	</div>

	<div id="chart_div" style="padding-left: 200px;"></div>
</body>
</html>