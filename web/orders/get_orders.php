<?php
	include '../common/trackerman_api.php';

	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$limit = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 16;
	$offset = ($page-1)*$limit;
	
	$json = TrackermanAPI::listOrders($limit, $offset);
	
	foreach ($json["results"] as &$valor) {
    	$valor["client_name"] =  $valor["client"]["lastname"].", ".$valor["client"]["name"];
    	$valor["items"] = count($valor["order_items"]);
    	unset($valor["client"]);
    	unset($valor["order_items"]);
	}

	$result["total"] = $json["paging"]["total"];
	$result["rows"] = $json["results"];
	echo json_encode($result);