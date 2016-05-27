<?php
	include '../common/trackerman_api.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 0;
	$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 200;
	$offset = ($page-1)*$limit;
	
	$json = TrackermanAPI::listProducts($limit, $offset);

	if($page == 0) {
		echo json_encode($json["results"]);
	} 
	else{
		$result["total"] = $json["paging"]["total"];
		$result["rows"] = $json["results"];
		echo json_encode($result);
	}