<?php
	include '../common/trackerman_api.php';

	$id = intval($_REQUEST['id']);

	$json = TrackermanAPI::getOrder($id);

	$result["total"] = count($json["order_items"]);
	$result["rows"] = $json["order_items"];
	echo json_encode($result);