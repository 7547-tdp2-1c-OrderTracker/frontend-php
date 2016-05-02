<?php
	include '../common/trackerman_api.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 100;
	$offset = ($page-1)*$limit;
	
	$json = TrackermanAPI::listSellers($limit, $offset);

	echo json_encode($json["results"]);