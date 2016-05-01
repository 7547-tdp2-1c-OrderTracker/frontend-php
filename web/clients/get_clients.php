<?php
	include '../common/trackerman_api.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 16;
	$offset = ($page-1)*$limit;
	
	$json = TrackermanAPI::listClients($limit, $offset);

	$result["total"] = $json["paging"]["total"];
	$result["rows"] = $json["results"];
	echo json_encode($result);