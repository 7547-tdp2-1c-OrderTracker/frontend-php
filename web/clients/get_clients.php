<?php
	include '../common/trackerman_api.php';

	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$limit = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 20;
	$offset = ($page-1)*$limit;
	
	$json = TrackermanAPI::listClients($limit, $offset, false);

	$result["total"] = $json["paging"]["total"];
	$result["rows"] = $json["results"];
	echo json_encode($result);